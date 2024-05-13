<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-02 17:55:30
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-09-09 17:39:18
 */

namespace App\Admin\Controllers\Contract;

use App\Models\Contract\ContractRebate;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class RebateController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ContractRebate(), function (Grid $grid) {
            $grid->model()->orderByDesc('order_time', 'id')->where('aid', Admin::user()->id); //筛选当前代理订单
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->export();

            $grid->column('order_no');
            $grid->column('user_id')->help('当前订单的下单用户');
            $grid->column('user_referrer')->help('当前订单用户的上级代理');
            $grid->column('deep')->help('代理商层级(1为直推2为间推3为间推的间推以此类推)');
            $grid->column('rebate_type')->using(ContractRebate::$rebateTypeMap)->label();
            $grid->column('contract_pair');
            $grid->column('side')->using(ContractRebate::$sideMap);
            $grid->column('margin', '保证金');
            $grid->column('fee');
            $grid->column('rebate_rate')->percentage();
            $grid->column('rebate', '佣金');
            $grid->column('status')->using(ContractRebate::$statusMap)->dot()->help('用户成功持仓合约后会产生返佣订单，每日12:00会自动结算历史佣金');
            $grid->column('order_time', '订单时间')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('order_time', '订单时间')->date();
                $filter->equal('id')->width(3);
                $filter->equal('user_referrer')->width(3);
                $filter->equal('order_no')->width(3);
                $filter->equal('aid', '收佣UID')->width(3);
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
