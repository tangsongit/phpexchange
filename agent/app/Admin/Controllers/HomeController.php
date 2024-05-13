<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-28 15:28:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-20 16:38:28
 */

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Models\Contract\ContractRebate;
use App\Http\Controllers\Controller;
use Dcat\Admin\Admin;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Grid;
use App\Models\AgentUser;
use App\Models\Contract\ContractAccount;
use App\Models\UserWallet;
use App\Models\User;

class HomeController extends Controller
{

    public function index(Content $content)
    {
        $this->build($content);
        return $content->header('个人中心');
    }
    public function build(Content $content)
    {
        $content->row($this->baseInfo()); //基本信息
        $content->row(function (Row $row) {
            $row->column(6, new Examples\CountUser()); #总注册
            // $column->row(new Examples\Tickets());
            $row->column(3, new Examples\NewUsers()); #已认证
            $row->column(3, new Examples\NewDevices()); #今日注册量
        });

        $content->row(function (Row $row) {
            $row->column(6, new Examples\Invitation()); #邀请码
            $row->column(6, new Examples\InvitateCode()); #邀请地址
        });
        $content->row($this->wallet_contract()); //合约账户
        $content->row($this->wallet_basic()); //基本账户
    }
    /**
     * @description: 基本信息 
     * @param {*}
     * @return {*}
     */
    public function baseInfo()
    {
        $user = User::find(Admin::user()->id); // 代理商/渠道商UID
        // 获取用户身份
        if ($user->is_place && $user->is_agency) {
            $identify = '代理商/渠道商';
        } elseif ($user->is_place) {
            $identify = '渠道商';
        } elseif ($user->is_agency) {
            $identify = '代理商';
        } else {
            return $this->error('');
        }
        $team_count = collect(get_childs($user->user_id))->count(); //团队总人数
        $rate = AgentUser::find($user->user_id)
            ->only([
                'rebate_rate',
                'rebate_rate_exchange',
                'rebate_rate_subscribe',
                'rebate_rate_contract',
                'rebate_rate_option',
                'place_rebate_rate'
            ]);

        // 代理商专属返佣信息（1、历史返佣 2、待结算）
        $rebate_info = '';
        if (Admin::user()->inRoles([2, 3])) {
            $rebate_info = "<div class=\"mycol\">返佣信息："
                . ContractRebate::query()->where('aid', Admin::user()->id)->where('status', 1)->sum('rebate') . "(历史总返佣) "
                . ContractRebate::query()->where('aid', Admin::user()->id)->where('status', 0)->sum('rebate') . "(待返佣)"
                . "</div>";
        }
        $rebate_rate_info = '';
        if (Admin::user()->inRoles([2, 3])) { //如果为代理商
            $rebate_rate_info .= "<div class=\"mycol\">手续费返佣比例：{$rate['rebate_rate']}%(默认)</div>";
        }
        if (Admin::user()->inRoles([3])) { //如果为渠道商
            $rebate_rate_info .= "<div class=\"mycol\">盈亏返佣比例：{$rate['place_rebate_rate']}%</div>";
        }
        $content = <<<HTML
        <div class='my-container-top card'>
        <h3 class="my-title">
            <span>基本信息</span>
        </h3>
        <div span='24' class='myrow'>
            <div class="mycol">{$identify}UID：{$user->user_id}</div>
            <div class="mycol">团队总人数：{$team_count}</div>
                {$rebate_rate_info}
                <!-- {$rate['rebate_rate_exchange']}%(币币) 
                {$rate['rebate_rate_subscribe']}%(申购) 
                {$rate['rebate_rate_contract']}%(合约) 
                {$rate['rebate_rate_option']}%(期权)  -->
        </div>
        <div class="myrow">
            <div class="mycol">手机：+$user->country_code  $user->phone</div>
            <div class="mycol">邮箱：{$user->email}</div>
            $rebate_info
        </div>
        <div><div>
        </div>
HTML;
        return $content;
    }
    // 合约账户
    public function wallet_contract()
    {
        $grid = Grid::make(ContractAccount::query()->where('user_id', Admin::user()->id), function (Grid $grid) {
            $grid->disableActions()
                ->disablePagination()
                ->disableRefreshButton()
                ->disableRowSelector()
                ->disableToolbar();
            $grid->column('coin_name', '币种名称');
            $grid->column('usable_balance', '可用资产');
            $grid->column('cash_deposit', '持仓保证金');
            $grid->column('total_rebate', '委托冻结');
        });
        return <<<EOF
                <div class='card'>
                    <h3 class="my-title">
                        <span>资产信息(合约账户)</span>
                    </h3>
                    <div>
                    $grid
                    </div>
                </div>
        EOF;
    }
    // 资产信息
    public function wallet_basic()
    {

        $grid = Grid::make(Userwallet::query()->where('user_id', Admin::user()->id), function (Grid $grid) {
            $grid->disableActions()
                ->disablePagination()
                ->disableRefreshButton()
                ->disableRowSelector()
                ->disableToolbar();
            $grid->column('coin_name', '币种名称');
            $grid->column('usable_balance', '可用金额');
            $grid->column('freeze_balance', '冻结金额');
            $grid->column('cash_deposit', '保证金');
        });
        return <<<EOF
                <div class='card'>
                    <h3 class="my-title">
                        <span>资产信息(基本账户)</span>
                    </h3>
                    <div>
                    $grid
                    </div>
                </div>
        EOF;
    }
}
