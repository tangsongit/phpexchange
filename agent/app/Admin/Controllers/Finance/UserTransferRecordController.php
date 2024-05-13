<?php

namespace App\Admin\Controllers\Finance;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\User;
use App\Models\UserTransferRecord;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

use Dcat\Admin\Http\Controllers\AdminController;

class UserTransferRecordController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected $title = "划转记录";
    protected function grid()
    {
        $user_id = Admin::user()->id;
        $base_ids = collect(get_childs($user_id))->pluck('user_id')->toArray();
        $base_ids[] = $user_id;
        $query = UserTransferRecord::with('user')
            ->whereIn('user_id', $base_ids);
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->withBorder();
            // xlsx
            $titles = ['id' => 'ID', 'user_id' => 'UID', 'username' => '用户名', 'referrer_name' => Admin::user()->roles[0]->name, 'coin_name' => '币名', 'direction' => '方向', 'amount' => '金额', 'datetime' => '时间', 'status' => '状态'];
            $grid->export();
            $grid->column('user_id', '用户UID')->link(function ($value) { //点击查看用户详细资料
                return admin_url('user/team-list', $value);
            });
            $grid->column('user.username', '用户名');
            $grid->column('user.referrer', Admin::user()->roles[0]->name . 'UID')->help('充值用户的' . Admin::user()->roles[0]->name . 'UID<br>(0表示无上级代理)');
            $grid->coin_name;
            $grid->column('direction', '方向')->display(function () {
                return (UserTransferRecord::$accountMap[$this->draw_out_direction] ?? '--') . ' -> ' . (UserTransferRecord::$accountMap[$this->into_direction] ?? '--');
            });
            $grid->amount;
            $grid->column('datetime', '时间');
            $grid->column('status', '状态')->using(UserTransferRecord::$statusMap)->dot([1 => 'success', 2 => 'error']);

            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('datetime', '日期')->datetime();
                $filter->equal('id')->width(3);
                $filter->like('account', '用户账号')->placeholder("请输入用户账户")->width(3);
                $filter->equal('user.referrer', Admin::user()->roles[0]->name . 'UID')->width(3);
                // $filter->equal('into_direction')->placeholder("请输入转入账户")->width(3);
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
        return Show::make($id, new UserTransferRecord(), function (Show $show) {
            $show->id;
            $show->user_id;
            $show->coin_id;
            $show->coin_name;
            $show->draw_out_direction;
            $show->into_direction;
            $show->amount;
            $show->status;
            $show->datetime;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new UserTransferRecord(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('coin_id');
            $form->text('coin_name');
            $form->text('draw_out_direction');
            $form->text('into_direction');
            $form->text('amount');
            $form->text('status');
            $form->text('datetime');
        });
    }
}
