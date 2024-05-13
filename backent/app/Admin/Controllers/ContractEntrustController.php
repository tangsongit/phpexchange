<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\ContractEntrust\BatchCancel;
use App\Admin\Actions\ContractEntrust\cancel;
use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\ContractEntrust;
use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

class ContractEntrustController extends AdminController
{
    public function statistics($query)
    {

        // 统计 1、单量 2、保证金   3、盈利
        $base_data = $query->get(['profit', 'margin', 'settle_profit']);

        $count = $base_data->count();
        $margin = $base_data->sum('margin');
        $profit = $base_data->map(function ($v) {
            return [
                'profit' => $v['settle_profit'] ?: $v['profit']
            ];
        })->sum('profit');
        $con = '<code>' . '单量：' . $count . 'USDT</code> ';
        $con .= '<code>' . '保证金：' . $margin . 'USDT</code> ';
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
        $query = ContractEntrust::with('user')
            ->whereHas('user', function ($q) {
                // $q->where('is_system', 0);
            });
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->model()->orderByDesc('id');
            $grid->export()->titles([
                'id'    => 'ID',
                'order_no' => '订单号',
                'order_type_side' => '交易类型',
                'symbol'    => '合约Symbol',
                'type'      => '委托类型',
                'margin'    => '保证金',
                'fee'      => '手续费',
                'profit'    => '盈亏',
                'status'    => '交易进度',
                'updated_at' => '更新时间',
                'created_at' => '创建时间'
            ])->rows(function ($rows) {
                foreach ($rows as &$row) {
                    if ($row['order_type'] == 1 && $row['side'] == 1) {
                        $row['order_type_side'] = '买入开多';
                    } elseif ($row['order_type'] == 1 && $row['side'] == 2) {
                        $row['order_type_side'] = '卖出开空';
                    } elseif ($row['order_type'] == 2 && $row['side'] == 1) {
                        $row['order_type_side'] = '买入平空';
                    } else {
                        $row['order_type_side'] = '卖出平多';
                    }
                    $row['type'] = ContractEntrust::$typeMap[$row['type']];
                    $row['status'] = ContractEntrust::$statusMap[$row['status']];
                }
                return $rows;
            });
            #统计
            $grid->header(function () use ($grid, $query) {
                $grid->model()->getQueries()->unique()->each(function ($v) use ($query) {
                    if (in_array($v['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) return;
                    call_user_func_array([$query, $v['method']], $v['arguments'] ?? []);
                });
                return $this->statistics($query);
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableQuickEdit();
                $actions->disableEdit();
                $actions->disableView();

                if (in_array($actions->row->status, [ContractEntrust::status_wait, ContractEntrust::status_trading])) {
                    $actions->append(new cancel());
                }
            });
            $grid->disableCreateButton();
            $grid->disableBatchDelete();
            //            $grid->disableRowSelector();

            $grid->tools([new BatchCancel()]);

            $grid->column('id')->sortable();
            $grid->column('order_no');
            $grid->column('user_id');
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
            //            $grid->column('order_type');
            //            $grid->column('side');
            //            $grid->column('contract_id');
            //            $grid->column('contract_coin_id');
            $grid->column('symbol');
            $grid->column('type')->using(ContractEntrust::$typeMap);
            $grid->column('lever_rate');
            $grid->column('entrust_price');
            //            $grid->column('trigger_price');
            $grid->column('amount');
            $grid->column('traded_amount');
            //            $grid->column('margin');
            $grid->column('avg_price');
            $grid->column('margin');
            $grid->column('fee')->display(function ($v) {
                return in_array($this->status, [
                    ContractEntrust::status_cancel
                ]) ? 0 : $v;
            });
            $grid->column('profit');
            $grid->column('settle_profit');
            $grid->column('status')->using(ContractEntrust::$statusMap)->dot([
                1 => 'primary',
                2 => 'danger',
                3 => 'success',
                4 => 'info',
            ], 'primary')->filter(
                Grid\Column\Filter\In::make(ContractEntrust::$statusMap)
            );
            //            $grid->column('hang_status');
            //            $grid->column('cancel_time');
            //            $grid->column('ts');
            $grid->column('updated_at')->sortable();
            $grid->column('created_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->whereBetween('ts', function ($q) {
                    $start = $this->input['start'] ? strtotime($this->input['start']) : null;
                    $end = $this->input['end'] ? strtotime($this->input['end']) : null;
                    $q->whereBetween('ts', [$start, $end + 86399]);
                }, '时间')->date();
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
                $filter->equal('user.pid', '代理商UID')->width(3);
                $filter->where('agent_id', function ($query) {
                    $base_ids = collect(User::getChilds($this->input))->pluck('user_id');
                    $query->whereHas('user', function ($query) use ($base_ids) {
                        $query->whereIn('user_id', $base_ids);
                    });
                }, '链上查询')->placeholder('输入代理商UID查询该代理链上委托')->width(3);
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
