<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-17 18:20:20
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-09-09 17:38:10
 */


namespace App\Admin\Controllers\Place;

use App\Admin\Actions\Place\AddPlace;
use App\Admin\Actions\Place\ResetPassword;
use App\Admin\Actions\Place\ResetRate;
use App\Models\Place;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Admin\Renderable\TradeStatistics;
use App\Models\UserWalletLog;
use Dcat\Admin\Widgets\Table;
use App\Models\ContractEntrust;
use App\Models\Otc\UserLegalOrder;
use App\Models\User;

class PlaceTreeController extends AdminController
{
    public function grid()
    {
        $user_id = Admin::user()->id;
        $base_ids = collect(User::getChilds($user_id))->where('is_place', 1)->pluck('user_id')->toArray();
        $base_ids[] = $user_id;
        $query = Place::with('agentUser')
            ->whereIn('user_id', $base_ids);
        return Grid::make($query, function (Grid $grid) use ($user_id) {
            $grid->model()->orderByDesc("created_at");
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->disableBatchDelete();
            $grid->disableEditButton();
            $grid->withBorder();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->style('display:none');
                $filter->equal("pid", "上级UID")->width(3);
                $filter->equal('user_id')->width(3);
            });
            $grid->export();
            $grid->showColumnSelector();
            $grid->column('user_id', Admin::user()->roles[0]->name . 'UID');
            $grid->column('agentUser.username', '用户名')->help('用户名是用于登录合伙人后台的用户名')->tree()->append(function () {
                $count = collect(User::getChilds($this->user_id))->where('is_place', 1)->count();
                return "（{$count}）";
            });
            $grid->column("pid", "上级渠道商UID");
            $grid->column('agentUser.name', '姓名');
            $grid->column('phone', '手机')->display(function () {
                return "+" . $this->country_code . $this->phone;
            });
            $grid->column('agentUser.remark', '备注');
            $grid->column('email');
            $grid->column('content', '统计')->display('统计')->expand(TradeStatistics::make());
            $grid->column('agentUser.place_rebate_rate', '默认返佣率')->display(function ($v) {
                return blank($v) ? "" : "{$v}%";
            })->help('渠道商返佣比例，该字段仅用于记录，系统并不会调用这个字段进行返佣操作');
            $grid->column("团队总人数")->display(function () {
                return count((array)get_childs($this->user_id));
            })->help('该渠道商的链上的人数');
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
                    ->pluck('amount_sum', 'coin_name')
                    ->toArray();
                $otc_deposit_buy = UserLegalOrder::query() //otc买入
                    ->whereIn('user_id', $team_ids)
                    ->where('status', 4)
                    ->where('type', 'buy')
                    ->groupBy('currency')
                    ->selectRaw('sum(number) as amount_sum,currency as coin_name')
                    ->pluck('amount_sum', 'coin_name')
                    ->toArray();
                $otc_deposit_sell = UserLegalOrder::query() //otc卖出
                    ->whereIn('user_id', $team_ids)
                    ->where('status', 4)
                    ->where('type', 'sell')
                    ->groupBy('currency')
                    ->selectRaw('sum(number) as amount_sum,currency as coin_name')
                    ->pluck('amount_sum', 'coin_name')
                    ->toArray();
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
            // $grid->actions(function (Grid\Displayers\Actions $action) {
            //     $action->append(new ResetRate());
            //     $action->append(new ResetPassword());
            //     $action->append(new \App\Admin\Actions\Place\DeletePlace());
            // });
        });
    }
}
