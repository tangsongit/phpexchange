<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-02 17:55:30
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 21:39:33
 */

namespace App\Models\Contract;


use Illuminate\Database\Eloquent\Model;

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
}
