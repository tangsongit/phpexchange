<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-02 17:55:30
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 21:40:27
 */

namespace App\Models\Contract;

use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContractRebate extends Model
{

    protected $table = 'contract_rebate';
    protected $casts = [
        'rebate_rate' => 'float',
        'rebate' => 'float',
        'margin' => 'float',
        'fee'   => 'float',
        'order_time' => 'datetime'
    ];
    protected $guarded = [];

    public static $rebateTypeMap = [
        "contract_direct_open_reward" => "合约直推开仓返佣",
        "contract_indirect_open_reward" => "合约间推开仓返佣",
        "contract_direct_flat_reward" => "合约直推平仓返佣",
        "contract_indirect_flat_reward" => "合约间推平仓返佣"
    ];
    public static $statusMap = [
        0 => '待结算',
        1 => '已结算'
    ];
    public static $sideMap = [
        1 => '买入',
        2 => '卖出'
    ];
    public static $contractPairMap = [
        'BTCUSDT' => 'BTCUSDT',
        'ETHUSDT' => 'ETHUSDT',
        'BCHUSDT' => 'BCHUSDT',
        'BSVUSDT' => 'BSVUSDT',
        'XRPUSDT' => 'XRPUSDT',
        'TRXUSDT' => 'TRXUSDT',
        'EOSUSDT' => 'EOSUSDT',
        'LINKUSDT' => 'LINKUSDT',
        'LTCUSDT' => 'LTCUSDT',
        'ETCUSDT' => 'ETCUSDT',
        'DASHUSDT' => 'DASHUSDT',
        'DOTUSDT' => 'DOTUSDT',
        'DOGEUSDT' => 'DOGEUSDT',
        'FILUSDT' => 'FILUSDT'
    ];


    /**
     * @description: 结算奖励
     * @param {*} $id 记录ID
     * @return {*} boolean
     */
    public function settle()
    {
        try {
            DB::commit();
            // 1、发放奖励至用户
            $user = User::find($this->aid);
            $user->update_wallet_and_log(1, 'usable_balance', $this->rebate, UserWallet::asset_account, $this->rebate_type);
            // 2、更新结算状态
            $this->status = 1;
            $this->save();
            // 3、发送通知给用户
            DB::commit();
            return true;
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return false;
        }
    }
    public static function getToBeSettleList()
    {
        return self::query()
            ->where('status', 0)
            ->get();
    }
}
