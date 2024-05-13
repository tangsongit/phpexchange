<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/9
 * Time: 16:15
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContractEntrust extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'contract_entrust';
    protected $guarded = [];

    public $appends = ['surplus_amount', 'status_text'];

    protected $casts = [
        'entrust_price' => 'real',
        'trigger_price' => 'real',
        'avg_price' => 'real',
        'margin' => 'float',
        'fee' => 'float'
    ];

    const status_cancel = 0;
    const status_wait = 1;
    const status_trading = 2;
    const status_completed = 3;
    public static $statusMap = [
        self::status_cancel => '已撤单',
        self::status_wait => '未成交',
        self::status_trading => '部分成交',
        self::status_completed => '全部成交',
    ];

    public static $typeMap = [
        // 1限价交易 2市价交易 3止盈止损
        1 => '限价交易',
        2 => '市价交易',
        3 => '止盈止损',
    ];

    public function getStatusTextAttribute()
    {
        return self::$statusMap[$this->status];
    }

    public function getSurplusAmountAttribute()
    {
        if ($this->type == 1) {
            return ($surplus_amount = $this->amount - $this->traded_amount) < 0 ? 0 : $surplus_amount;
        } else {
            return null;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function user_auth()
    {
        return $this->hasOne(UserAuth::class, 'user_id', 'user_id');
    }

    public function can_trade()
    {
        if ($this->status == self::status_wait || $this->status == self::status_trading) {
            return true;
        }
        return false;
    }

    public function can_cancel()
    {
        if ($this->status == self::status_wait || $this->status == self::status_trading) {
            return true;
        }
        return false;
    }

    public static function getContractBuyList($type, array $where_data)
    {
        $where = [
            ['contract_id', '=', $where_data['contract_id']],
            ['side', '=', 1],
            ['order_type', '=', $where_data['order_type']],
            ['user_id', '!=', $where_data['user_id']],
        ];
        if ($type == 1) {
            //限价交易 市价挂单优先 然后取符合条件的按价格排序
            $market_entrust = DB::table('contract_entrust')->where($where)
                ->whereIn('status', [ContractEntrust::status_wait, ContractEntrust::status_trading])
                ->where('type', 2)->orderBy('created_at');
            return self::query()->where($where)
                ->whereIn('status', [ContractEntrust::status_wait, ContractEntrust::status_trading])
                ->where('entrust_price', '>=', $where_data['entrust_price'])
                ->union($market_entrust)
                ->orderBy('entrust_price', 'desc')->orderBy('created_at')->get();
        } elseif ($type == 2) {
            //市价交易 则买单得有价格
            return self::query()->where($where)
                ->whereIn('status', [ContractEntrust::status_wait, ContractEntrust::status_trading])
                ->whereIn('type', [1, 3])->orderBy('entrust_price', 'desc')->orderBy('created_at')->get();
        }
    }

    public static function getContractSellList($type, array $where_data)
    {
        $where = [
            ['contract_id', '=', $where_data['contract_id']],
            ['side', '=', 2],
            ['order_type', '=', $where_data['order_type']],
            ['user_id', '!=', $where_data['user_id']],
        ];
        if ($type == 1) {
            //限价交易 市价挂单优先 然后取符合条件的按价格排序
            $market_entrust = DB::table('contract_entrust')->where($where)
                ->whereIn('status', [ContractEntrust::status_wait, ContractEntrust::status_trading])
                ->where('type', 2)
                ->orderBy('created_at');
            return self::query()->where($where)
                ->whereIn('status', [ContractEntrust::status_wait, ContractEntrust::status_trading])
                ->where('entrust_price', '<=', $where_data['entrust_price'])
                ->union($market_entrust)
                ->orderBy('entrust_price', 'asc')->orderBy('created_at')->get();
        } elseif ($type == 2) {
            //市价交易 则卖单得有价格
            return self::query()->where($where)
                ->whereIn('status', [ContractEntrust::status_wait, ContractEntrust::status_trading])
                ->whereIn('type', [1, 3])
                ->orderBy('entrust_price', 'asc')
                ->orderBy('created_at')
                ->get();
        }
    }

    /**
     * @description: 获取用户合约交易的盈亏数据
     * @param {*} $user_id 需要查询到用户ID
     * @return {*}
     */
    public static function getUserProfit($user_id)
    {
        return self::query()
            ->where('user_id', $user_id)
            ->where('status', self::status_completed)
            ->get()
            ->map(function ($v) {
                return [
                    'profit' => $v['settle_profit'] ?: $v['profit']
                ];
            })->sum('profit');
    }
}
