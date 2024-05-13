<?php

namespace App\Admin\Controllers\Exchange;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\InsideTradeSell;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Table;

class InsideTradeSellController extends AdminController
{

    protected $title = "卖出委托";
    protected function grid()
    {
        $user_id = Admin::user()->id;
        $base_ids = collect(User::getChilds($user_id))->pluck('user_id')->toArray();
        $base_ids[] = $user_id;
        $sql = InsideTradeSell::with(['user'])
            ->whereIn("user_id", $base_ids);
        return Grid::make($sql, function (Grid $grid) {
            $grid->model()->orderByDesc("id");
            $grid->withBorder();
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableBatchDelete();
            $grid->disableDeleteButton();
            $grid->export();

            $grid->id->sortable();
            $grid->order_no;
            $grid->column('user.username', '用户');
            $grid->symbol;
            $grid->type->using(InsideTradeSell::$typeMap)->label();
            $grid->entrust_price;
            $grid->trigger_price;
            //            $grid->quote_coin_id;
            //            $grid->base_coin_id;
            $grid->amount;
            $grid->traded_amount;
            $grid->money;
            $grid->traded_money;
            $grid->status->using(InsideTradeSell::$statusMap)->dot([
                1 => 'primary',
                2 => 'danger',
                3 => 'success',
                4 => 'info',
            ], 'primary');

            $grid->created_at;
            //            $grid->updated_at->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('created_at', "时间")->datetime();
                $filter->equal('user_id', 'UID')->width(2);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(3);
                $filter->equal('user.referrer', Admin::user()->roles[0]->name . 'UID')->width(3);
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
        return Show::make($id, new InsideTradeSell(), function (Show $show) {
            $show->id;
            $show->order_no;
            $show->user_id;
            $show->entrust_type;
            $show->symbol;
            $show->type;
            $show->entrust_price;
            $show->trigger_price;
            $show->quote_coin_id;
            $show->base_coin_id;
            $show->amount;
            $show->traded_amount;
            $show->money;
            $show->traded_money;
            $show->status;
            $show->hang_status;
            $show->cancel_time;
            $show->created_at;
            $show->updated_at;
            $show->panel()
                ->tools(function ($tools) {
                    $tools->disableEdit();
                    //$tools->disableList();
                    $tools->disableDelete();
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
        return Form::make(new InsideTradeSell(), function (Form $form) {

            $form->text('order_no');
            $form->text('user_id');
            $form->text('entrust_type');
            $form->text('symbol');
            $form->text('type');
            $form->text('entrust_price');
            $form->text('trigger_price');
            $form->text('quote_coin_id');
            $form->text('base_coin_id');
            $form->text('amount');
            $form->text('traded_amount');
            $form->text('money');
            $form->text('traded_money');
            $form->text('status');
            $form->text('hang_status');
            $form->text('cancel_time');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
