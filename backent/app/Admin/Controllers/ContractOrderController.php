<?php

namespace App\Admin\Controllers;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\ContractEntrust;
use App\Models\ContractOrder;
use App\Models\ContractPair;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\UserWalletLog;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

class ContractOrderController extends AdminController
{
    public function statistics($query)
    {
        $builder1 = $query;
        $builder3 = UserWalletLog::query()->where('rich_type', 'usable_balance')
            ->where('account_type', UserWallet::sustainable_account)
            ->where('log_type', 'position_capital_cost')
            ->whereHas('user', function ($q) {
                $q->where('is_system', 0);
            });
        $params = request()->only(['user_id', 'username', 'symbol', 'ts', 'agent_id']);
        if (!empty($params)) {
            if (!empty($params['user_id'])) { //按照用户名
                $builder3->where('user_id', $params['user_id']);
            }
            if (!empty($params['username'])) { //按照用户名
                $username = $params['username'];
                $builder3->whereHas('user', function ($q) use ($username) {
                    $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                });
            }
            if (!empty($params['symbol'])) { //按照币种
                $pair = ContractPair::query()->where('symbol', $params['symbol'])->select('id', 'symbol')->first();
                if (!blank($pair)) {
                    $builder3->where('sub_account', $pair['id']);
                }
            }
            if (!empty($params['ts']) && !empty($params['ts']['start'])) {   //按照时间
                $start = $params['ts']['start'] ? strtotime($params['ts']['start']) : null;
                $end = $params['ts']['end'] ? strtotime($params['ts']['end']) : null;
                $builder3->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end);
            }
            if (!empty($params['agent_id'])) {  //按照代理商UID查询链上
                $referrer = $params['agent_id'];
                $childs = collect(User::getChilds($referrer))->pluck('user_id')->toArray();
                $builder3->where(function ($query) use ($childs) {
                    $query->whereIn('user_id', $childs);
                });
            }
        }

        $total_buy_fee = (clone $builder1)->whereHas('buy_user', function ($q) {
            $q->where('is_system', 0);
        })->sum('trade_buy_fee');
        $total_sell_fee = (clone $builder1)->whereHas('sell_user', function ($q) {
            $q->where('is_system', 0);
        })->sum('trade_sell_fee');
        $total_fee = $total_buy_fee + $total_sell_fee; // 总手续费
        $total_profit_1 = (clone $builder1)
            ->with('buy_entrust')
            ->whereHas('buy_entrust', function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('is_system', 0);
                });
            })
            ->get()
            ->map(function ($v) {
                $buy_entrust = $v['buy_entrust'];
                $v['buy_entrust'] =  [
                    'profit' => $buy_entrust['settle_profit'] ?: $buy_entrust['profit'],
                ];
                return $v;
            })
            ->sum('buy_entrust.profit'); //买盈亏
        $total_profit_2 = (clone $builder1)
            ->with('sell_entrust')
            ->whereHas('sell_entrust', function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('is_system', 0);
                });
            })
            ->get()
            ->map(function ($v) {
                $sell_entrust = $v['sell_entrust'];
                $v['sell_entrust'] =  [
                    'profit' => $sell_entrust['settle_profit'] ?: $sell_entrust['profit'],
                ];
                return $v;
            })
            ->sum('sell_entrust.profit'); //卖盈亏
        $total_profit = $total_profit_1 + $total_profit_2;
        $total_cost = $builder3->sum('amount'); //总资金费

        $con = '<code>总手续费：' . abs($total_fee) . 'USDT</code> ' . '<code>总资金费：' . (float)abs($total_cost) . 'USDT</code> ' . '<code>总盈亏：' . (float)$total_profit . 'USDT</code> ';
        return Alert::make($con, '统计')->info();
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $query = ContractOrder::query()->where(function ($q) {
            $q->whereHas('buy_user', function ($q) {
                // $q->where('is_system', 0);
            })->orWhereHas('sell_user', function ($q) {
                // $q->where('is_system', 0);
            });
        });
        return Grid::make($query, function (Grid $grid) use ($query) {
            // return Grid::make(new ContractOrder(), function (Grid $grid) {
            $grid->model()->orderByDesc('id');

            #统计
            $grid->header(function () use ($grid, $query) {
                $grid->model()->getQueries()->unique()->each(function ($v) use ($query) {
                    if (in_array($v['method'], ['get', 'paginate', 'orderBy', 'orderByDesc'])) return;
                    call_user_func_array([$query, $v['method']], $v['arguments'] ?? []);
                });
                return $this->statistics($query);
            });

            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableRowSelector();

            $grid->column('id')->sortable();
            //            $grid->column('contract_id');
            $grid->column('symbol');
            $grid->column('order_type')->using([1 => '开仓', 2 => '平仓'])->label();
            $grid->column('lever_rate');
            $grid->column('buy_id')->link(function ($value) {
                return admin_url('contract-entrust', $value);
            });
            $grid->column('sell_id')->link(function ($value) {
                return admin_url('contract-entrust', $value);
            });

            $grid->column('user_id', '用户UID')->display(function () {
                if ((User::find($this->buy_user_id)->is_system ?? 1) == 0) {
                    return $this->buy_user_id;
                } elseif ((User::find($this->sell_user_id)->is_system ?? 1) == 0) {
                    return $this->sell_user_id;
                }
            });
            // $grid->column('buy_user_id');
            // $grid->column('sell_user_id');
            $grid->column('unit_price');
            $grid->column('trade_amount');
            $grid->column('fee', '手续费')->display(function () {
                if ((User::find($this->buy_user_id)->is_system ?? 1) == 0) {
                    return $this->trade_buy_fee;
                } elseif ((User::find($this->sell_user_id)->is_system ?? 1) == 0) {
                    return $this->trade_sell_fee;
                }
            });
            // $grid->column('trade_buy_fee');
            // $grid->column('trade_sell_fee');
            $grid->column('ts', '时间')->display(function ($v) {
                return date('Y-m-d H:i:s', $v);
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->whereBetween('ts', function ($q) {
                    $start = $this->input['start'] ? strtotime($this->input['start']) : null;
                    $end = $this->input['end'] ? strtotime($this->input['end']) : null;
                    $q->whereBetween('ts', [$start, $end + 86399]);
                }, '时间')->date();
                $filter->where('user_id', function ($q) {
                    $q->where('buy_user_id', $this->input)->orWhere('sell_user_id', $this->input);
                }, 'UID')->width(2);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('buy_user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    })->orWhereHas('sell_user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(3);
                $filter->equal('symbol')->width(3);
                $filter->where('agent_id', function ($query) {
                    $referrer = $this->input;
                    $childs = collect(User::getChilds($referrer))->pluck('user_id')->toArray();
                    $query->where(function ($query) use ($childs) {
                        $query->whereIn('buy_user_id', $childs)
                            ->orWhereIn('sell_user_id', $childs);
                    });
                }, '链上查询')->placeholder('输入代理商UID查看链上用户订单')->width(3);
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new ContractOrder(), function (Show $show) {
            $show->field('id');
            $show->field('contract_id');
            $show->field('symbol');
            $show->field('lever_rate');
            $show->field('order_type');
            $show->field('buy_id');
            $show->field('sell_id');
            $show->field('buy_user_id');
            $show->field('sell_user_id');
            $show->field('unit_price');
            $show->field('trade_amount');
            $show->field('trade_buy_fee');
            $show->field('trade_sell_fee');
            $show->field('ts');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ContractOrder(), function (Form $form) {
            $form->display('id');
            $form->text('contract_id');
            $form->text('symbol');
            $form->text('lever_rate');
            $form->text('order_type');
            $form->text('buy_id');
            $form->text('sell_id');
            $form->text('buy_user_id');
            $form->text('sell_user_id');
            $form->text('unit_price');
            $form->text('trade_amount');
            $form->text('trade_buy_fee');
            $form->text('trade_sell_fee');
            $form->text('ts');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
