<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-25 09:59:49
 */


namespace App\Admin\Controllers;

use App\Admin\Actions\Agent\ChangeStatus;
use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Models\AgentUser;

use App\Admin\Actions\Agent\DeleteAgent;
use App\Admin\Actions\Agent\ToBePlace;
use App\Admin\Renderable\TradeStatistics;

class AgentController extends \Dcat\Admin\Controllers\AdminController
{
    protected $title = "代理商列表";
    public function grid()
    {
        return Grid::make(Agent::with('agent_user'), function (Grid $grid) {
            $grid->model()->orderByDesc('user_id');
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableQuickEdit();
                $actions->disableView();
                if ($actions->row->status == 0) {
                    $actions->append(new ChangeStatus());
                };
                $actions->append(new DeleteAgent());
                $actions->append(ToBePlace::make()->canClick($this->is_place == 0));
            });
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->column('user_id', '代理商UID')->sortable()->link(function ($v) {
                return admin_url('/users/', [$v]);
            }, '');
            $grid->column('agent_user.username', '用户名')->help('用于登录渠道商/代理商后台的用户名');
            $grid->column('agent_user.name', '姓名')->help('代理商/渠道商姓名');
            $grid->column("pid", "邀请人UID");
            $grid->column("referrer", "上级代理UID");
            $grid->column('invite_code', '邀请码')->copyable();
            $grid->column("团队人数")->display(function () {
                return collect(User::getChilds($this->user_id))->count();
            });
            $grid->column('content', '统计')->display('统计')->expand(TradeStatistics::make());
            $grid->column('agent_user.rebate_rate', '默认返佣比率')->append('%');
            // $grid->column('agent_user.rebate_rate_exchange', '币币返佣比率')->append('%');
            // $grid->column('agent_user.rebate_rate_subscribe', '申购返佣比率')->append('%');
            $grid->column('agent_user.rebate_rate_contract', '合约返佣比率')->append('%');
            // $grid->column('agent_user.rebate_rate_option', '期权返佣比率')->append('%');

            $grid->column('identity', '身份')->display(function () {
                if ($this->is_agency == 1) $iden[] = '代理商';
                if ($this->is_place == 1) $iden[] = '渠道商';
                return $iden ?? [];
            })->label();
            $grid->column('agent_user.status', '状态')->using(AgentUser::$userStatusMap)->dot([0 => 'danger', 1 => 'success']);
            $grid->column('agent_user.created_at', '创建时间');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->between('agent_user.created_at', '创建时间')->date();
                $filter->equal('user_id', '代理商UID')->width(4);
                $filter->like("agent_user.username", "代理商名称")->width(5);
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
            $show->account;
            $show->account_type;
            $show->username;
            $show->pid;

            $show->path;
            $show->country_code;
            $show->phone;

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
        return Form::make(Agent::with('agent_user'), function (Form $form) {
            $form->hidden('user_id')->readOnly();
            $form->text('agent_user.username', '登录账户')->required()->help('用户登录代理后台的账户');
            $form->text('agent_user.name', '姓名')->required()->help('登记代理姓名');
            $form->text('invite_code', '邀请码')->rules('required');
            $form->text('pid', '邀请人UID');
            $form->text('referrer', '上级代理商UID');
            $form->rate('agent_user.rebate_rate', '默认返佣比率')->required();
            $form->radio('agent_user.rebate_rate_exchange', '详细设置')
                ->when(1, function (Form $form) {
                    $form->rate('agent_user.rebate_rate_exchange', '币币返佣比率');
                    $form->rate('agent_user.rebate_rate_subscribe', '申购返佣比率');
                    $form->rate('agent_user.rebate_rate_contract', '合约返佣比率');
                    $form->rate('agent_user.rebate_rate_option', '期权返佣比率');
                })->options([0 => '隐藏', 1 => '显示'])->default(0);
            $form->image("agent_user.avatar", "头像")->rules('required:users,avatar')->autoUpload();
            $form->password('agent_user.password', "密码")->placeholder('留空则不修改');
            $form->saving(function (Form $form) {
                if (blank($form->agent_user['password'])) { //如果密码为空
                    $form->deleteInput('agent_user.password');
                }
                $form->is_agency = 1; # 1:标记为代理商
                if (User::isInviteCodeExist($form->code, $form->user_id)) {
                    return $form->error('邀请码已存在');
                }
                if (AgentUser::isUsernameExist($form->agent_user['username'], $form->user_id)) {
                    return $form->error('用户名已存在');
                }
            });

            // $form->saved(function (Form $form) {
            //     if ($form->isCreating()) {
            //         $id = $form->getKey();
            //         User::find($id)->update(['is_agency' => 1]);
            //         DB::table("agent_admin_role_users")->insert(["role_id" => 2, "user_id" => $id]);
            //     }
            // });
        });
    }
}
