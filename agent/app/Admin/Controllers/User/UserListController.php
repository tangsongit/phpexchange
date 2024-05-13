<?php


namespace App\Admin\Controllers\User;

use App\Admin\Actions\User\UpdateToAgent;
use App\Admin\Renderable\UserTradeStatistics;
use App\Admin\Renderable\UserWalletExpand;
use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\Recharge;
use App\Models\User;
use App\Models\UserGrade;
use App\Models\UserWallet;
use App\Models\Withdraw;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Admin\Actions\User\UpdateToPlace;
use App\Admin\Repositories\TeamList;
use App\Models\Otc\UserLegalOrder;

class UserListController extends \Dcat\Admin\Http\Controllers\AdminController
{
    protected  $title = "会员列表";

    // use PreviewCode;

    protected function grid()
    {
        $base_ids = User::getDirectChilds(Admin::user()->id);
        $query = User::query()
            ->from('users as user')
            ->leftJoin('user_wallet as wallet', 'user.user_id', '=', 'wallet.user_id')
            ->where('wallet.coin_name', 'USDT')
            ->whereIn('user.user_id', $base_ids);
        return Grid::make(new TeamList($query), function (Grid $grid) {
            $grid->model()->orderByDesc('created_at');
            // xlsx
            $titles = ['user_id' => 'UID', 'pid' => 'PID', 'referrer_name' => '代理', 'phone' => '电话', 'email' => '邮箱', 'invite_code' => '邀请码', 'user_grade' => '级别', 'user_auth_level' => '认证状态', 'status' => '状态', 'created_at' => '时间'];
            $grid->export();
            // 关闭操作 关闭创建按钮，关闭快速编辑
            $grid->disableBatchDelete();
            $grid->disableCreateButton()->disableQuickEditButton();

            $grid->withBorder();
            $grid->column('user_id', '用户UID')->sortable();
            $grid->column('username');
            $grid->column("referrer", Admin::user()->roles[0]->name . "UID");
            $grid->column('pid', '邀请人UID');
            $grid->column('remark', '备注')->editable()->help('上级用户可以给任意伞下用户进行备注。该备注与代理渠道备注不同');
            $grid->column('合约盈亏')->display(function () {
                return \App\Models\ContractEntrust::getUserProfit($this->user_id);
            })->help('指的是用户在进行合约交易产生的盈亏数据');
            $grid->column('total_money', '总入金')->display(function () { #入金
                $deposit = Recharge::query()
                    ->where("user_id", $this->user_id)
                    ->where('status', 1)
                    ->sum("amount");
                $deposit_otc = UserLegalOrder::query()
                    ->where('user_id', $this->user_id)
                    ->where('status', 4)
                    ->where('type', 'buy')
                    ->sum('number');
                $money = $deposit + $deposit_otc;
                return "<span style='color: cornflowerblue'>{$money}</span>";
            })->help('指的是向平台充值的金额数量');

            $grid->column('withdraw', '总出金')->display(function () { #出金
                $money = Withdraw::query()
                    ->where("user_id", $this->user_id)
                    ->where('status', 3)
                    ->sum("total_amount"); #提币记录
                $money_otc = UserLegalOrder::query()
                    ->where('user_id', $this->user_id)
                    ->where('status', 4)
                    ->where('type', 'sell')
                    ->sum('number');
                $money = $money + $money_otc;
                return "<span style='color: cornflowerblue'>{$money}</span>";
            })->help('指的是向平台提现的金额数量');
            $grid->column('withdraw_fee', '提币手续费')->display(function () {
                $money = Withdraw::query()
                    ->where("user_id", $this->user_id)
                    ->where('status', 3)
                    ->sum("withdrawal_fee"); #提币记录
                return "<span style='color: cornflowerblue'>{$money}</span>";
            });

            $grid->column('usable_balance', 'USDT余额')->sortable()->help('基本账户中USDT的钱包余额(详细金额请往财务中查看)');
            $grid->column('财务')->display('财务')->expand(UserWalletExpand::make());
            $grid->column('统计')->display('统计')->expand(UserTradeStatistics::make());

            $grid->status->using(User::$userStatusMap)->dot([0 => 'danger', 1 => 'success']);
            $grid->trade_status->using(User::$userStatusMap)->dot([0 => 'danger', 1 => 'success']);
            $grid->column('identity', '身份')->display(function () {
                if ($this->is_agency == 1) $iden[] = '代理商';
                if ($this->is_place == 1) $iden[] = '渠道商';
                if (!isset($iden)) {
                    return '普通用户';
                }
                return $iden ?? [];
            })->label();
            $grid->created_at('注册时间')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $grades = AgentGrade::getCachedGradeOption();
                $lk = last(array_keys($grades));

                $filter->between('create_time', '注册时间')->datetime();
                $filter->like('username', "用户名")->width(4);
                $filter->where('user_id', function ($query) {
                    $query->where('user.user_id', $this->input);
                }, "用户UID")->width(4);
                $filter->like('status', "状态")->select(User::$userStatusMap)->width(4);
            });


            $grid->actions(function (Grid\Displayers\Actions $action) {
                $action->disableEdit();
                $action->disableDelete();
                if (Admin::user()->inRoles([1, 3])) {
                    $action->append(new UpdateToPlace());
                }
                if (Admin::user()->inRoles([1, 2, 3])) {
                    $action->append(new UpdateToAgent());
                }
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
            //$show->last_login_time;
            //  $show->last_login_ip;
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
            $form->display('user_id');
            $form->text('remark');
            // $form->text('account_type');
            // $form->text('username');
            // $form->text('pid');
            // $form->text('deep');
            // $form->text('path');
            // $form->text('country_code');
            // $form->text('phone');
            // $form->text('email');
            // $form->text('avatar');
            // $form->text('password');
            // $form->text('payword');
            // $form->text('invite_code');
            // $form->text('user_grade');
            // $form->text('user_identity');
            // $form->text('user_auth_level');
            // $form->text('login_code');
            // $form->text('status');
            // $form->text('reg_ip');
            // $form->text('last_login_time');
            // $form->text('last_login_ip');

            // $form->display('created_at');
            // $form->display('updated_at');
        });
    }
}
