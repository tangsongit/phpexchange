<?php


namespace App\Admin\Controllers\Contract;

use App\Admin\Renderable\TradeStatistics;
use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\User;
use App\Models\UserSubscribeRecord;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use \Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Hash;

class PurchaseController extends  AdminController
{
    protected $title = "申购记录";

    public function grid()
    {
        $user_id = Admin::user()->id;
        $base_ids = collect(User::getChilds($user_id))->pluck('user_id')->toArray();
        $base_ids[] = $user_id;
        $query = UserSubscribeRecord::with('user')
            ->whereIn('user_id', $base_ids);

        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->model()->orderByDesc('subscription_time');
            $grid->withBorder();

            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableBatchDelete();
            $grid->disableRowSelector();
            $grid->export();

            $grid->column('user_id', '用户UID');
            $grid->column('user.referrer', Admin::user()->roles[0]->name . 'UID');
            $grid->column('payment_amount', '认购数量');
            $grid->column('payment_currency', '支付币种');
            $grid->column('subscription_time', '申购时间')->date();
            $grid->column('subscription_currency_name', '申购币种');
            $grid->column('subscription_currency_amount', '申购数量');
            $grid->column('subscription_time', '申购时间');



            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->between('subscription_time', '申购时间')->datetime();
                $filter->equal('user_id', '用户UID')->width(4);
                $filter->equal("user.referrer", Admin::user()->roles[0]->name . "UID")->width(4);
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
        return Show::make($id, new Agent(), function (Show $show) {

            $show->user_id;
            $show->payment_amount;
            $show->payment_currency;
            $show->subscription_time;
            $show->subscription_currency_name;
            $show->subscription_currency_amount;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    // protected function form()
    // {
    //     return Form::make(new Agent(), function (Form $form) {
    //         $form->text("user_id")->readOnly();
    //         $form->text("username")->readOnly();
    //         $form->text("name")->readOnly();
    //         //$form->select("is_agency","是否用户")->options(Agent::$type);
    //         $form->image("avatar")->autoUpload();
    //         $form->text("invite_code")->display(false);
    //         $form->password('password', '密码')->rules('required');
    //         //$form->password('password_confirmation', '确认密码')->rules('required');
    //         $form->disableViewButton();
    //         $form->disableDeleteButton();
    //         $form->disableListButton();

    //         $form->saving(function (Form $form) {

    //           /* if( $form->model()->password != $form->password ){
    //                 return $form->error("两次密码不一致");
    //             }*/

    //             if( $form->password != $form->model()->password ) {
    //                 $form->password = Hash::make($form->password);
    //             }

    //         });

    //     });
    // }
}
