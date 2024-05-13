<?php


namespace App\Admin\Controllers\Agent;

use App\Admin\Renderable\TradeStatistics;
use App\Models\Agent;
use App\Models\User;
use App\Models\UserWalletLog;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use \Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Dcat\Admin\Widgets\Table;
use App\Admin\Actions\Agent\ResetRate;
use App\Admin\Actions\Agent\ResetPassword;
use App\Admin\Actions\Agent\AddAgent;
use App\Models\ContractEntrust;
use App\Models\Otc\UserLegalOrder;

class AgentListController extends  AdminController
{
    protected $title = "代理列表";
    public function grid()
    {
        $agentIds = Agent::getChildAgentList(Admin::user()->id);
        $sql = Agent::with('agentUser')
            ->whereIn("user_id", $agentIds);
        return Grid::make($sql, function (Grid $grid) {
            $grid->model()->orderByDesc("created_at");
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->disableBatchDelete();
            $grid->disableEditButton();
            $grid->withBorder();

            // 工具栏(当用户为代理商)
            if (Admin::user()->inRoles([2])) {
                $grid->tools([new AddAgent()]); //增加代理
            }

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->between('created_at', '创建时间')->date();
                $filter->equal('user_id', '代理商UID')->width(4);
                $filter->like("username", "代理商名称")->width(5);
            });
            $grid->showColumnSelector();
            $grid->hideColumns([
                'agentUser.rebate_rate_exchange',
                'agentUser.rebate_rate_subscribe',
                'agentUser.rebate_rate_contract',
                'agentUser.rebate_rate_option'
            ]);
            $grid->column('user_id', '代理商UID');
            $grid->column("referrer", "上级代理商UID");
            $grid->column('agentUser.name', '姓名');
            $grid->column('agentUser.username', '用户名');
            $grid->column('agentUser.remark', '备注')->editable()->help('(点击即可编辑)备注只能直属上级给下级编辑');
            $grid->column('phone', '手机')->display(function () {
                return "+" . $this->country_code . $this->phone;
            });
            $grid->column('email');
            $grid->column('content', '统计')->display('统计')->expand(TradeStatistics::make());
            $grid->column('agentUser.rebate_rate', '默认返佣率')->append('%');
            $grid->column('agentUser.rebate_rate_exchange', '币币返佣率')->append('%');
            $grid->column('agentUser.rebate_rate_subscribe', '申购返佣率')->append('%');
            $grid->column('agentUser.rebate_rate_contract', '合约返佣率')->append('%');
            $grid->column('agentUser.rebate_rate_option', '期权返佣率')->append('%');
            $grid->column("团队总人数")->display(function () {
                return count((array)get_childs($this->user_id));
            })->help('该代理商的链上的人数');
            $grid->column("团队入金人数")->display(function () {
                // 获取团队人员id
                $team_ids = collect(get_childs($this->user_id))->pluck('user_id')->toArray();
                $count_recharge = User::query()
                    ->whereIn('user_id', $team_ids)
                    ->whereHas('user_wallet_log', function ($query) {
                        $query->whereIn('log_type', ['admin_recharge', 'recharge']);
                    })
                    ->count();
                $count_otc = User::query()
                    ->whereIn('user_id', $team_ids)
                    ->whereHas('otc_order', function ($query) {
                        $query->where('status', 4);
                    })
                    ->count();
                return ($count_recharge + $count_otc);
            })->help('团队中有过充值记录的人数');
            $grid->column('团队净入金')->display(function () {
                // 获取团队人员
                $this->team_ids = $team_ids = collect(get_childs($this->user_id))->pluck('user_id')->toArray();
                $wallet_deposit =  UserWalletLog::query()
                    ->whereIn('log_type', [
                        'admin_recharge', //系统充值
                        'recharge_audit',
                        'recharge', //充值
                        'withdraw',  //提现
                        'reject_withdraw',
                        'cancel_withdraw',
                    ])
                    ->where('rich_type', 'usable_balance')
                    ->whereIn('user_id', $team_ids)
                    ->groupBy('coin_name')
                    ->selectRaw('sum(amount) as amount_sum,coin_name')
                    ->pluck('amount_sum', 'coin_name');

                $otc_deposit_buy = UserLegalOrder::query() //otc买入
                    ->whereIn('user_id', $team_ids)
                    ->where('status', 4)
                    ->where('type', 'buy')
                    ->groupBy('currency')
                    ->selectRaw('sum(number) as amount_sum,currency as coin_name')
                    ->pluck('amount_sum', 'coin_name');
                $otc_deposit_sell = UserLegalOrder::query() //otc卖出
                    ->whereIn('user_id', $team_ids)
                    ->where('status', 4)
                    ->where('type', 'sell')
                    ->groupBy('currency')
                    ->selectRaw('sum(number) as amount_sum,currency as coin_name')
                    ->pluck('amount_sum', 'coin_name');
                $otc_deposit = merge_array_del($otc_deposit_buy, $otc_deposit_sell);
                $this->team_not_deposit = merge_array_add($wallet_deposit, $otc_deposit);
                return  'USDT：' . ($this->team_not_deposit['USDT'] ?? 0);
            })->expand(function () {
                return Table::make(['币种', '净入金额'], $this->team_not_deposit);
            })->help('团队净入金=团队内总充值-总提现');
            // 如果该用户属于经销商时显示
            if (Admin::user()->inRoles([1, 3])) {
                $grid->column('整条链盈亏(合约)')->display(function () {
                    return ContractEntrust::query()
                        ->whereIn('user_id', $this->team_ids)->sum('profit');
                })->label('green')->help('整条连指的是伞下所有用户合约交易产生的盈亏，以用户的角度来计算盈亏');
                $grid->created_at;
            }
            // 操作栏
            $grid->actions(function (Grid\Displayers\Actions $action) {
                $action->append(new ResetRate());
                $action->append(new ResetPassword());
                $action->append(new \App\Admin\Actions\Agent\DeleteAgent());
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
            $show->deep;
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
        $agentIds = Agent::getChildAgentList(Admin::user()->id);
        $query = Agent::with('agentUser')
            ->whereIn("user_id", $agentIds);
        return Form::make($query, function (Form $form) {
            $form->text('agentUser.remark');
        });
    }
}
