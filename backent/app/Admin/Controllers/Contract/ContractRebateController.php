<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-04 09:34:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 18:51:21
 */

namespace App\Admin\Controllers\Contract;

use App\Models\Contract\ContractRebate;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use App\Admin\Actions\Agent\ContractSettle;

class ContractRebateController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ContractRebate(), function (Grid $grid) {
            $grid->model()->orderByDesc('order_time', 'id'); //倒序排序
            // $grid->disableActions();
            $grid->disableCreateButton();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableView();
                if ($this->status) {
                    $actions->append(ContractSettle::make()->addHtmlClass('btn btn-sm btn-outline-primary disabled'));
                } else {
                    $actions->append(ContractSettle::make()->addHtmlClass('btn btn-sm btn-outline-primary'));
                }
            });
            $grid->column('id', '返佣ID')->sortable();
            $grid->column('order_no');
            $grid->column('aid', '受益人UID')->help('当前订单受益人ID');
            $grid->column('user_id')->help('当前订单的下单用户');
            $grid->column('deep', '返佣层级')->help('代理商层级(1为直推2为间推3为间推的间推以此类推)');
            $grid->column('rebate_type')->using(ContractRebate::$rebateTypeMap)->label();
            $grid->column('contract_pair');
            $grid->column('side')->using(ContractRebate::$sideMap);
            $grid->column('margin', '保证金');
            $grid->column('fee');
            $grid->column('rebate_rate')->percentage();
            $grid->column('rebate', '佣金')->help('本单代理商可拿奖金');
            $grid->column('status')->using(ContractRebate::$statusMap)->dot([0 => 'grey', 1 => 'green'])->help('用户成功持仓合约后会产生返佣订单，每日12:00会自动结算历史佣金');
            $grid->column('order_time', '订单时间')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('order_time', '订单时间')->date();
                $filter->equal('id')->width(3);
                $filter->equal('user_referrer')->width(3);
                $filter->equal('order_no')->width(3);
                $filter->equal('aid', '受益人UID')->width(3);
                $filter->equal('status')->select(ContractRebate::$statusMap)->width(4);
                $filter->in('contract_pair')->multipleSelect(ContractRebate::$contractPairMap)->width(4);
            });
        });
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ContractRebate(), function (Form $form) {
            $form->display('id');
            $form->text('order_no');
            $form->text('user_id');
            $form->text('user_referrer');
            $form->text('deep');
            $form->text('rebate_type');
            $form->text('contract_pair');
            $form->text('side');
            $form->text('amount');
            $form->text('fee');
            $form->text('rebate_rate');
            $form->text('status');
            $form->text('order_time');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
