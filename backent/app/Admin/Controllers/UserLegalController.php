<?php
/*
 * @Author: your name
 * @Date: 2021-06-01 15:30:15
 * @LastEditTime: 2021-08-14 11:28:04
 * @LastEditors: GuaPi
 * @Description: In User Settings Edit
 * @FilePath: \Dcat\app\Admin\Controllers\RechargeManualController.php
 */

namespace App\Admin\Controllers;

use App\Admin\Repositories\RechargeManual;
use App\Admin\Actions\Userlegal\Agree;
use App\Admin\Actions\Userlegal\Reject;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Controllers\AdminController;
use App\Models\UserLegalOrder;


class UserLegalController extends AdminController
{
    protected $translation = 'user-legal';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new UserLegalOrder(), function (Grid $grid) {
            $grid->model()->orderByDesc('id');
            $grid->model()->with(['user']);
            $grid->disableCreateButton();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableQuickEdit();
                $actions->disableView();

            });
            $grid->id;
            $grid->user_id;
            $grid->column('user.username', '用户名');
            $grid->order_on;
            $grid->type->using(['buy' => '买入', 'sell' => '卖出'])->label([
                'buy' => 'green', 'sell' => 'orange'
            ]);
            $grid->currency;
            $grid->amount;
            $grid->number;
            $grid->unitPrice;


            $grid->remarks;
            $grid->is_callback->using([0 => '未回调', 1 => '已回调']);
            $grid->status->using([1 => '代付款', 2 => '待放币', 3 => '申诉中', 4 => '交易完成', 5 => '已取消'])->badge([0 => 'primary', 1 => 'success', 2 => 'danger']);
            $grid->created_at->sortable();
            $grid->updated_at->sortable();
            
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('user_id', 'UID')->width(2);
                $filter->equal('order_on', "订单号")->width(2);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(3);


                $filter->between('created_at', "时间")->datetime()->width(4);

                $filter->where('status', function ($q) {
                    $q->where('status', $this->input);
                }, '状态')->select(UserLegalOrder::$statusMap)->width(3);
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
        return Show::make($id, new UserLegalOrder(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('order_on');
            $show->field('type');
            $show->field('currency');
            $show->field('amount');
            $show->field('number');
            $show->field('unitPrice');
            $show->field('remarks');
            $show->field('is_callback');
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
        return Form::make(new UserLegalOrder(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('order_on');
            $form->text('currency');
            $form->text('amount');
            $form->text('number');
            $form->text('unitPrice');
            $form->text('is_callback');
            $form->text('remarks');
            $form->switch('status');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
