<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-09-08 14:47:25
 */

namespace App\Admin\Controllers;

use App\Admin\Actions\ContractAccount\Recharge;
use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\SustainableAccount;
use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Admin;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

class ContractAccountController extends AdminController
{
    protected function statistics($query)
    {
        // 统计 总资产 持仓保证金  委托冻结
        $base_data = $query->get(['margin_name', 'usable_balance', 'used_balance', 'freeze_balance']);

        $usable_balance = $base_data->sum('usable_balance');
        $used_balance = $base_data->sum('used_balance');
        $freeze_balance = $base_data->sum('freeze_balance');

        $con = "<code>可用保证金：{$usable_balance} </code>";
        $con .= "<code>持仓保证金：{$used_balance} </code>";
        $con .= "<code>委托冻结：{$freeze_balance} </code>";
        return Alert::make($con, '统计')->info();
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $query = SustainableAccount::query();
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->model()->orderByDesc('user_id');
            $grid->column('id')->sortable();

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

                //                if (Admin::user()->can('user-recharge')) {
                //                    $actions->append(new Recharge());
                //                }
            });
            $grid->disableCreateButton();
            $grid->disableRowSelector();

            $grid->column('user_id');
            //            $grid->column('coin_id');
            //            $grid->column('coin_name');
            $grid->column('margin_name');
            $grid->column('usable_balance')->sortable();
            $grid->column('used_balance');
            $grid->column('freeze_balance');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('user_id', 'UID')->width(2);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(3);
                $filter->where('agent_id', function ($q) {
                    $base_ids = collect(User::getChilds($this->input))->pluck('user_id')->toArray();
                    $q->whereIn('user_id', $base_ids);
                }, '链上用户UID')->width(3);
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
        return Show::make($id, new SustainableAccount(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('coin_id');
            $show->field('coin_name');
            $show->field('margin_name');
            $show->field('usable_balance');
            $show->field('used_balance');
            $show->field('freeze_balance');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new SustainableAccount(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('coin_id');
            $form->text('coin_name');
            $form->text('margin_name');
            $form->text('usable_balance');
            $form->text('used_balance');
            $form->text('freeze_balance');
        });
    }
}
