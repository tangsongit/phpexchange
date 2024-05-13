<?php


namespace App\Admin\Controllers;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PersonController extends AdminController
{
    protected $title = "个人信息";

    public function grid()
    {

        return Grid::make(User::query()->find(Admin::user()->id), function (Grid $grid) {
            $grid->model()->where(["is_agency" => 1, "user_id" => Admin::user()->id]);
            /* $grid->actions(function (Grid\Displayers\Actions $actions) {
                  $actions->disableDelete();
                  $actions->disableQuickEdit();
                  $actions->disableEdit();
                  $actions->disableView();
              });*/
            $grid->disableActions();
            $grid->disableViewButton();
            $grid->disableDeleteButton();
            $grid->disableCreateButton();
            // $grid->disableEditButton();
            $grid->withBorder();

            $grid->column('user_id', 'UID');
            $grid->username;
            $grid->column('deep', "代理等级")->using(AgentGrade::getCachedGradeOption());
            $grid->column("上级代理")->display(function () { #上级代理
                $user = User::find($this->pid);
                if (empty($user)) return "<laber style='color: ;'>无</laber>";
                return "<laber style='color: #0d77e4'>$user->user_id</laber>";
            });

            $grid->name;

            $grid->column('subscribe_rebate_rate', '申购返佣比率');
            $grid->column('contract_rebate_rate', '合约返佣比率');
            $grid->column('option_rebate_rate', '期权返佣比率');

            $grid->column(__('PC端用户邀请链接'))->display(function () {
                return config('app.pc_invite_url') . $this->invite_code;
            })->copyable();
            $grid->column(__('移动端用户邀请链接'))->display(function () {
                return config('app.h5_invite_url') . $this->invite_code;
            })->copyable();
            $grid->column(__('下级代理开户链接'))->display(function () {
                return config('app.agent_invite_url') . $this->invite_code;
            })->copyable();

            $grid->created_at->sortable();

            /*  $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();

            });*/
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
        return Show::make($id, new User(), function (Show $show) {
            $show->user_id;
            $show->username;
            $show->path;
            $show->phone;
            $show->deep->using(Agent::$grade);
            $show->password;
            $show->payword;
            $show->invite_code;
            $show->created_at;
            $show->panel()
                ->tools(function ($tools) {
                    $tools->disableEdit();
                    $tools->disableList();
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
        return Form::make(new User(), function (Form $form) {

            $form->hidden("user_id");
            $form->text("username")->required();
            $form->text("name")->required();

            $form->text('subscribe_rebate_rate', '申购返佣比率')->required();
            $form->text('contract_rebate_rate', '合约返佣比率')->required();
            $form->text('option_rebate_rate', '期权返佣比率')->required();

            $form->image('avatar', "头像")->autoUpload();
            $form->password('password');
            $form->text("invite_code")->display(false);
            $form->text("deep")->display(false);

            $form->saving(function (Form $form) {

                $agent = Admin::user();
                // 代理条件限制
                if (
                    $form->subscribe_rebate_rate > $agent->subscribe_rebate_rate
                    || $form->contract_rebate_rate > $agent->contract_rebate_rate
                    || $form->option_rebate_rate > $agent->option_rebate_rate
                ) {
                    return $form->error('代理条件不能高于上级');
                }

                if ($form->isCreating()) { #创建
                    #如果代理商等级为5级，则不可再发展下级代理

                    $deep = $agent->deep + 1;

                    if ($deep > 4) return $form->error("代理最大为5级，您当前：5级，不可添加");
                    if (blank($form->password)) return $form->error("密码不能为空");
                    //                    if( blank($form->avatar) ) return $form->error("头像不能为空");
                    //if( $deep == 4 ){
                    $form->invite_code = User::gen_invite_code();
                    //}

                    $form->is_agency = 1; # 1:标记为代理商

                    $form->deep = $deep;
                    $exist = User::query()->where("username", $form->username)->first();
                    if ($exist) return $form->error("用户名已存在");

                    $pass = Hash::make($form->password);
                    $form->password = $pass;
                }

                if ($form->isEditing()) { #修改

                    $mark = Admin::user()->password;
                    if ($mark != $form->password) {
                        $pass = Hash::make($form->password);
                        $form->password = $pass;
                    }
                }
            });

            $form->saved(function (Form $form) {

                $create = $form->isCreating();
                if ($create) {
                    $id = $form->getKey();

                    DB::table("users")->where("user_id", $id)->update([
                        "pid" => Admin::user()->id,
                        "referrer" => Admin::user()->id,
                        "is_agency" => 1,
                        /* "referrer"=>Admin::user()->referrer,*/
                        "id" => $id
                    ]);
                    DB::table("agent_admin_role_users")->insert(["role_id" => 2, "user_id" => $id]);
                }
            });
        });
    }
}
