<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:41:11
 */

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/10
 * Time: 15:46
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractTradeBuy extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'user_contract_trade_buy';
    protected $guarded = [];
    protected $attributes = [
        'amount' => null,
        'traded_amount' => 0,
        'money' => 0,
        'traded_money' => 0,
    ];

    public $appends = ['surplus_amount'];

    public function getSurplusAmountAttribute()
    {
        if ($this->type == 1) {
            return ($surplus_amount = $this->amount - $this->traded_amount) < 0 ? 0 : $surplus_amount;
        } else {
            return null;
        }
    }

    public static function getBuyTradeList($type, array $where_data)
    {
        $where = [
            ['base_coin_id', '=', $where_data['base_coin_id']],
            ['quote_coin_id', '=', $where_data['quote_coin_id']],
            ['user_id', '!=', $where_data['user_id']],
        ];
        if ($type == 1) {
            //限价交易 市价挂单优先 然后取符合条件的按价格排序
            $market_entrust = DB::table('inside_list_buy')->where($where)->where('type', 2)->orderBy('created_at');
            return self::query()->where($where)
                ->where('entrust_price', '>=', $where_data['entrust_price'])
                ->union($market_entrust)
                ->orderBy('entrust_price', 'desc')->orderBy('created_at')->get();
        } else {
            //市价交易 则买单得有价格
            return self::query()->where($where)->where('type', 1)->orderBy('entrust_price', 'desc')->orderBy('created_at')->get();
        }
    }
}