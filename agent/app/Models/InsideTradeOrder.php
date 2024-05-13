<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-28 15:28:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-05 18:06:43
 */

namespace App\Models;

use App\Events\TriggerEntrustEvent;
use Illuminate\Database\Eloquent\Model;

class InsideTradeOrder extends Model
{
    // 币币交易成交记录

    protected $table = 'inside_trade_order';
    protected $primaryKey = 'order_id';
    protected $guarded = [];

    protected $casts = [
        'unit_price' => 'float',
        'trade_amount' => 'flaot',
        'trade_money' => 'float',
        'trade_buy_fee' => 'float',
        'trade_sell_fee' => 'float',
    ];

    /**
     * 模型的事件映射
     * 触发止盈止损委托
     * @var array
     */
    //    protected $dispatchesEvents = [
    //        'created' => TriggerEntrustEvent::class,
    //    ];

    public function buy_user()
    {
        return $this->belongsTo(User::class, 'buy_user_id', 'user_id');
    }

    public function sell_user()
    {
        return $this->belongsTo(User::class, 'sell_user_id', 'user_id');
    }
}
