<?php


namespace App\Admin\Controllers;

use App\Admin\Actions\Agent\ChangeStatus;
use App\Models\Place;
use App\Models\AgentGrade;
use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Models\AgentUser;
use App\Admin\Actions\Place\AddPlace;
use App\Admin\Renderable\TradeStatistics;

class PlaceController extends \Dcat\Admin\Controllers\AdminController
{
    protected $title = "渠道商列表";
    public function grid()
    {
        return Grid::make(Place::with('agent_user'), function (Grid $grid) {
            $grid->model()->orderByDesc('user_id');

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableQuickEdit();
                $actions->disableView();
                if ($actions->row->status == 0) {
                    $actions->append(new ChangeStatus());
                }
                $actions->append(new \App\Admin\Actions\Place\ToBeAgent);
                $actions->append(new \App\Admin\Actions\Place\DeletePlace);
            });
            $grid->tools(new AddPlace());
            $grid->disableCreateButton();
            $grid->disableDeleteButton();

            $grid->column('user_id', '用户UID')->sortable()->link(function ($v) {
                return admin_url('/users/', [$v]);
            }, '');
            $grid->column('agent_user.username', '用户名')->help('用于登录渠道商/代理商后台的用户名');
            $grid->column('agent_user.name', '姓名')->help('代理商/渠道商姓名');
            $grid->column("pid", "邀请人UID");
            $grid->column("referrer", "代理商UID")->help('上级代理商UID');
            $grid->column('invite_code', '邀请码')->copyable();
            $grid->column("团队人数")->display(function () {
                return collect(User::getChilds($this->user_id))->count();
            });
            $grid->column('content', '统计')->display('统计')->expand(TradeStatistics::make());
            $grid->column('agent_user.place_rebate_rate', '返佣比例')->display(function ($v) {
                return blank($v) ? "" : "{$v}%";
            })->help('渠道商返佣比例，该字段仅用于记录，系统并不会调用这个字段进行返佣操作');
            $grid->column('agent_user.rebate_rate', '手续费返佣比例')->display(function ($v) {
                return blank($v) ? "" : "{$v}%";
            })->help('手续费返佣比例，如果为0则不返佣');
            $grid->column('agent_user.rebate_rate_canset', '可设下级返佣')->display(function ($v) {
                return blank($v) ? "" : "{$v}%";
            })->help('可以设置下级代理手续费返佣的最大值');
            $grid->column('identity', '身份')->display(function () {
                if ($this->is_agency == 1) $iden[] = '代理商';
                if ($this->is_place == 1) $iden[] = '渠道商';
                return $iden ?? [];
            })->label();
            $grid->column('status', '状态')->using(Place::$userStatusMap)->dot([0 => 'danger', 1 => 'success']);
            $grid->column('agent_user.created_at', '创建时间')->help('代理商/渠道商创建时间');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                // $filter->between('created_at', '创建时间')->date();
                $filter->equal('user_id', '渠道商UID')->width(4);
                $filter->like("agent_user.username", "渠道商名称")->width(5);
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
        return Show::make($id, new Place(), function (Show $show) {
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
        return Form::make(Place::with('agent_user'), function (Form $form) {
            $form->hidden('user_id')->readOnly();
            $form->text('agent_user.username', '登录账户')->required()->help('用户登录代理后台的账户');
            $form->text('agent_user.name', '姓名')->help('登记渠道商/代理商姓名');
            $form->text('invite_code', '邀请码')->rules('required');
            $form->text('pid', '邀请人UID');
            $form->text('referrer', '上级代理商UID');
            $form->image("agent_user.avatar", "头像")->rules('required:users,avatar')->autoUpload();
            $form->rate('agent_user.rebate_rate', '手续费返佣比例')->help('手续费返佣比例设为0，表示不返佣');
            $form->rate('agent_user.rebate_rate_canset', '可设下级手续费返佣比例')->help('可设下级手续费返佣比例，下级代理商返佣比例不能大于该值。当该值为空时下级返佣则不可大于当前渠道商手续费返佣');
            $form->rate('agent_user.place_rebate_rate', '渠道商返佣比例')->help('渠道商返佣比例，该字段仅用于记录，系统并不会调用这个字段进行返佣操作');
            $form->password('agent_user.password', "密码")->placeholder('留空则不修改');
            $form->saving(function (Form $form) {
                if (blank($form->agent_user['password'])) { //如果密码为空
                    $form->deleteInput('agent_user.password');
                }
                $form->is_place = 1; // 1:标记为渠道商
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
