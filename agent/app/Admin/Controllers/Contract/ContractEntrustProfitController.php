<?php

namespace App\Admin\Controllers\Contract;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\AgentUser;
use App\Models\ContractEntrust;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

class ContractEntrustProfitController extends AdminController
{
    public function statistics($query)
    {

        // 统计 1、单量 2、保证金   3、盈利
        $base_data = $query
            ->whereIn('status', [2, 3])
            ->get(['profit', 'margin', 'fee', 'settle_profit']);

        $count = $base_data->count();
        $margin = $base_data->sum('margin');
        $profit = $base_data->map(function ($v) {
            return [
                'profit' => $v['settle_profit'] ?: $v['profit']
            ];
        })->sum('profit');
        $fee = $base_data->sum('fee');
        $con = '<code>' . '成交单量：' . $count . '</code> ';
        $con .= '<code>' . '保证金：' . $margin . 'USDT</code> ';
        $con .= "<code> 手续费：" . $fee . "USDT</code> ";
        $con .= '<code>' . '盈亏：' . $profit . 'USDT</code> ';
        return Alert::make($con, '统计')->info();
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $user_id = Admin::user()->id;
        $base_ids = collect(User::getChilds($user_id))->pluck('user_id')->toArray();
        $base_ids[] = $user_id;
        $query = ContractEntrust::with(['user', 'user_auth'])
            ->whereIn('user_id', $base_ids);
        // ->where('profit', '<>', null);
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->model()->orderByDesc('id');
            $grid->withBorder();

            #统计
            $grid->header(function () use ($grid, $query) {
                $grid->model()->getQueries()->unique()->each(function ($v) use ($query) {
                    if (in_array($v['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) return;
                    call_user_func_array([$query, $v['method']], $v['arguments'] ?? []);
                });
                return $this->statistics($query);
            });

            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableBatchDelete();
            $grid->disableRowSelector();
            $grid->export();

            $grid->column('order_no');
            $grid->column('user_id', '用户UID')->help('下单用户的UID');
            $grid->column('user_auth.realname', '用户姓名')->help('显示实名后的用户姓名，未实名用户显示未空');
            $grid->column('user.referrer', '渠道商UID')->help('下单用户的上级渠道商UID');
            $grid->column('lead', '用户所属')->display(function ($v) {
                $parents = '';
                $parent_arr = User::getParentUsers($this->user_id);
                foreach ($parent_arr as $v) {
                    $name = AgentUser::find($v->user_id)->remark ?? null;
                    if ($name) {
                        $parents .= $name . '/';
                    }
                    if ($v->user_id == Admin::user()->id) break;
                }
                return substr($parents, 0, -1);
            })->limit(15)->help('用户所属渠道/代理商，以合伙人备注显示');
            $grid->column('order_type_side', '交易类型')->display(function () {
                if ($this->order_type == 1 && $this->side == 1) {
                    return '买入开多';
                } elseif ($this->order_type == 1 && $this->side == 2) {
                    return '卖出开空';
                } elseif ($this->order_type == 2 && $this->side == 1) {
                    return '买入平空';
                } else {
                    return '卖出平多';
                }
            })->label();
            $grid->column('symbol');
            $grid->column('type')->using(ContractEntrust::$typeMap)->filter(Grid\Column\Filter\In::make(ContractEntrust::$typeMap));
            $grid->column('lever_rate');
            $grid->column('entrust_price');
            //            $grid->column('trigger_price');
            $grid->column('amount');
            $grid->column('traded_amount');
            $grid->column('margin');
            $grid->column('avg_price');
            $grid->column('fee');
            $grid->column('profit')->label()->help('用户平仓才会结算盈亏，开仓盈亏值将为空')->sortable();
            // $grid->column('settle_profit')->label();
            $grid->column('status')->using(ContractEntrust::$statusMap)->dot([
                1 => 'primary',
                2 => 'danger',
                3 => 'success',
                4 => 'info',
            ], 'primary')->filter(
                Grid\Column\Filter\In::make(ContractEntrust::$statusMap)
            );
            $grid->column('created_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('created_at', '时间')->datetime();
                $filter->equal('user_id', 'UID')->width(3);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(3);
                $filter->equal('symbol')->width(3);
                $filter->where('type', function ($q) {
                    if ($this->input == 1) {
                        $q->where('order_type', 1)->where('side', 1);
                    } elseif ($this->input == 2) {
                        $q->where('order_type', 1)->where('side', 2);
                    } elseif ($this->input == 3) {
                        $q->where('order_type', 2)->where('side', 2);
                    } else {
                        $q->where('order_type', 2)->where('side', 1);
                    }
                }, '交易类型')->select([1 => '开多', 2 => '开空', 3 => '平多', 4 => '平空'])->width(3);
                $filter->equal('order_no')->width(6);
                $filter->equal('user.referrer', '渠道商UID')->width(3);
                $filter->where('agent_id', function ($query) {
                    $base_ids = collect(User::getChilds($this->input))->pluck('user_id');
                    $query->whereIn('user_id', $base_ids);
                }, '链上查询')->width(3);
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
        return Show::make($id, new ContractEntrust(), function (Show $show) {
            $show->field('id');
            $show->field('order_no');
            $show->field('order_type');
            $show->field('user_id');
            $show->field('side');
            $show->field('contract_id');
            $show->field('contract_coin_id');
            $show->field('symbol');
            $show->field('type');
            $show->field('entrust_price');
            $show->field('trigger_price');
            $show->field('amount');
            $show->field('traded_amount');
            $show->field('lever_rate');
            $show->field('margin');
            $show->field('fee');
            $show->field('status');
            $show->field('hang_status');
            $show->field('cancel_time');
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
        return Form::make(new ContractEntrust(), function (Form $form) {
            $form->display('id');
            $form->text('order_no');
            $form->text('order_type');
            $form->text('user_id');
            $form->text('side');
            $form->text('contract_id');
            $form->text('contract_coin_id');
            $form->text('symbol');
            $form->text('type');
            $form->text('entrust_price');
            $form->text('trigger_price');
            $form->text('amount');
            $form->text('traded_amount');
            $form->text('lever_rate');
            $form->text('margin');
            $form->text('fee');
            $form->text('status');
            $form->text('hang_status');
            $form->text('cancel_time');
            $form->text('ts');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
