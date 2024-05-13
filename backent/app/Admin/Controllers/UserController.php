<?php

namespace App\Admin\Controllers;


use App\Admin\Renderable\UserTradeStatistics;
use App\Admin\Renderable\UserWalletExpand;
use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\Country;
use App\Models\User;
use App\Models\UserGrade;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Admin\Actions\User\AddSystemUser;
use App\Admin\Actions\User\AddUser;
use App\Admin\Renderable\Parents;

class UserController extends AdminController
{
    protected $title = '用户列表';

    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                //$actions->disableQuickEdit();
                //$actions->disableEdit();
                $actions->disableView();

                if (Admin::user()->can('user-recharge')) {
                    $actions->append(new \App\Admin\Actions\User\recharge());
                    $actions->append(new \App\Admin\Actions\Pertain());
                    $actions->append(new \App\Admin\Actions\User\ModifyPassword());
                    $actions->append(new \App\Admin\Actions\User\RestorePassword());
                    $actions->append(new \App\Admin\Actions\User\UpdateToAgent());
                    $actions->append(new \App\Admin\Actions\User\UpdateToPlace());
                }
            });

            if (Admin::user()->can('addSystemUser')) {
                $grid->tools([new AddSystemUser()]);
                $grid->tools([new AddUser()]);
            }

            // xlsx
            $titles = ['user_id' => 'UID', 'pid' => 'PID', 'phone' => '电话', 'email' => '邮箱', 'invite_code' => '邀请码', 'user_grade' => '级别', 'user_auth_level' => '认证状态', 'status' => '状态', 'created_at' => '时间'];
            $grid->export()->titles($titles)->rows(function (array $rows) use ($titles) {
                foreach ($rows as $index => &$row) {
                    $row['user_grade'] = UserGrade::get_grade_info($row['user_grade'])['grade_name'] ?? $row['user_grade'];
                    $row['user_auth_level'] = User::$userAuthMap[$row['user_auth_level']];
                    $row['status'] = User::$userStatusMap[$row['status']];
                }
                return $rows;
            })->xlsx();

            $grades = AgentGrade::getCachedGradeOption();

            $grid->model()->orderByDesc('created_at');
            $grid->user_id;
            //            $grid->account;
            //            $grid->username;
            $grid->pid;

            $grid->phone;
            $grid->email;
            $grid->avatar->image('', 50, 50);
            $grid->invite_code;
            $grid->purchase_code;
            $grid->user_grade->display(function ($v) {
                return UserGrade::get_grade_info($v)['grade_name'] ?? $v;
            })->label('info');
            $grid->user_auth_level->using(User::$userAuthMap)->dot([0 => 'danger', 1 => 'info', 2 => 'success']);
            $grid->column('identity', '身份')->display(function () {
                if ($this->is_agency == 1) $iden[] = '代理商';
                if ($this->is_place == 1) $iden[] = '渠道商';
                return $iden ?? [];
            })->label();

            $grid->column('统计')->display('统计')->expand(UserTradeStatistics::make());
            $grid->column('资产')->display('资产')->expand(UserWalletExpand::make());
            $grid->column('上级')->display('查看上级...')->expand(Parents::make())->help('显示的第1个用户为直推用户，第2个为间推，第3个是间推的间推，以此类推');
            $grid->status->switch();
            $grid->trade_status->switch();
            $grid->column('is_system', '系统账户')->using([0 => '否', 1 => '是'])->badge([0 => 'danger', 1 => 'success'])->filter(Grid\Column\Filter\In::make([0 => '否', 1 => '是']));
            $grid->last_login_time;
            $grid->last_login_ip;
            $grid->created_at->sortable();

            //            $grid->disableViewButton();
            $grid->disableCreateButton();
            //$grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->disableBatchDelete();

            $grid->filter(function (Grid\Filter $filter) use ($grades) {
                $filter->equal('user_id', 'UID')->width(3);
                $filter->where('username', function ($q) {
                    $q->where('username', $this->input)->orWhere('phone', $this->input)->orWhere('email', $this->input);
                }, "用户名/手机/邮箱")->width(3);
                $filter->between('created_at', "时间")->date()->width(4);
                $filter->equal('pid', '代理商UID')->placeholder('输入邀请人UID/代理商UID')->width(3);
                $filter->where('agent_id', function ($query) {
                    $referrer = $this->input;
                    $childs = collect(get_childs($referrer))->pluck('user_id')->toArray();
                    $query->whereIn('user_id', $childs);
                }, '链上查询')->placeholder('代理商UID')->width(3);
            });
        });
    }

    public function agents(Request $request)
    {
        $q = $request->get('q');
        $options = Agent::query()->where(['pid' => $q, 'is_agency' => 1])->select(['id', 'username as text'])->get()->toArray();
        array_unshift($options, []);
        return $options;
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
        return Show::make($id, new User(), function (Show $show) {
            $show->user_id;
            $show->account;
            $show->account_type;
            $show->username;
            $show->pid;
            $show->deep;
            $show->path;
            $show->country_code;
            $show->phone;
            $show->email;
            $show->avatar;
            $show->password;
            $show->payword;
            $show->invite_code;
            $show->user_grade;
            $show->user_identity;
            $show->user_auth_level;
            $show->login_code;
            $show->status;
            $show->reg_ip;
            $show->last_login_time;
            $show->last_login_ip;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new User(), function (Form $form) {

            $form->text('user_id')->readOnly();
            $form->text('username')->rules("required:users,username");
            $form->text('name');
            $form->switch('status');
            $form->switch('trade_status');
            $form->text('pid', "上级ID")->rules("required:users,pid");
            $form->text('referrer', "代理ID");
            $form->text('invite_code')->disable();
        });
    }
}
