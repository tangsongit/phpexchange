<?php


namespace App\Admin\Controllers\User;


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
use App\Admin\Actions\User\UpdateToAgent;
use App\Admin\Repositories\TeamList;
use App\Models\AgentUser;
use App\Models\ContractEntrust;
use App\Models\Otc\UserLegalOrder;
use Illuminate\Support\Facades\DB;
use PDO;

class TeamListController extends \Dcat\Admin\Http\Controllers\AdminController
{
    protected  $title = "团队";

    // use PreviewCode;

    protected function grid()
    {
        $user_id = Admin::user()->id;
        $base_ids = collect(get_childs($user_id))->pluck('user_id')->toArray();

        $query = User::query()
            ->from('users as user')
            ->leftJoin('user_wallet as wallet', 'user.user_id', '=', 'wallet.user_id')
            ->where('wallet.coin_name', 'USDT')
            ->whereIn('user.user_id', $base_ids);
        return Grid::make(new TeamList($query), function (Grid $grid) {
            // $grid->model()->orderByRaw('user.user_id desc');
            $grid->model()->orderByDesc('usable_balance');
            // xlsx
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
            if (Admin::user()->inRoles([1, 3])) {
                $grid->column('合约盈亏')->display(function () {
                    $profit =  ContractEntrust::getUserProfit($this->user_id);
                    return "<span style=\"color:" . ($profit == 0 ? 'black' : ($profit > 0 ? 'green' : 'red')) . "\"> $profit</span>";
                })->help('指的是用户在进行合约交易产生的盈亏数据<br>(渠道商专属)')->label('#f7f7f9');
            }
            $grid->column('usable_balance', 'USDT余额')->sortable()->help('基本账户中USDT的钱包余额(详细金额请往财务中查看)');
            $grid->column('财务')->display('财务')->expand(UserWalletExpand::make());
            $grid->column('统计')->display('统计')->expand(UserTradeStatistics::make());

            $grid->column('status')->using(User::$userStatusMap)->dot([0 => 'danger', 1 => 'success']);
            $grid->column('trade_status')->using(User::$userStatusMap)->dot([0 => 'danger', 1 => 'success']);
            $grid->column('identity', '身份')->display(function () {
                if ($this->is_agency == 1) $iden[] = '代理商';
                if ($this->is_place == 1) $iden[] = '渠道商';
                if (!isset($iden)) {
                    return '普通用户';
                }
                return $iden ?? [];
            })->label();
            $grid->column('lead', '用户所属')->display(function ($v) {
                $parents = '';
                $parent_arr = User::getParentUsers($this->user_id)->reject(function ($user) {
                    return ($user->is_agency == 0 && $user->is_place == 0) ? 1 : 0;
                });
                foreach ($parent_arr as $v) {
                    $name = AgentUser::find($v->user_id)->remark ?? $v->username;
                    if ($name) {
                        $parents .= $name . '/';
                    }
                    if ($v->user_id == Admin::user()->id) break;
                }
                return substr($parents, 0, -1);
            })->limit(15)->help('用户所属渠道/代理商，以合伙人备注显示');
            $grid->column('created_at', '注册时间')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $grades = AgentGrade::getCachedGradeOption();
                $lk = last(array_keys($grades));

                $filter->whereBetween('created_at', function ($query) {
                    $query->whereBetween('user.created_at', [$this->input['start'], $this->input['end']]);
                }, '注册时间')->datetime();
                $filter->like('username', "用户名")->width(3);
                $filter->where('user_id', function ($query) {
                    $query->where('user.user_id', $this->input);
                }, "用户UID")->width(3);
                $filter->like('status', "状态")->select(User::$userStatusMap)->width(3);
                $filter->equal('pid', Admin::user()->roles[0]->name . "UID")->placeholder(Admin::user()->roles[0]->name . "/邀请人UID")->width(3);
                $filter->where('agent_id', function ($query) {
                    $referrer = $this->input;
                    $childs = collect(get_childs($referrer))->pluck('user_id')->toArray();
                    $query->whereIn('user.user_id', $childs);
                }, '链上查询')->placeholder(Admin::user()->roles[0]->name . "UID")->width(3);
            });

            $grid->actions(function ($action) {
                $action->disableEdit();
                $action->disableDelete();
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

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
