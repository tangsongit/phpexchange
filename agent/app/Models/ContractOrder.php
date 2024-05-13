<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-28 15:28:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-30 11:22:51
 */

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/7
 * Time: 17:52
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractOrder extends Model
{
    //#合约下单

    protected $primaryKey = 'id';
    protected $table = 'contract_order';
    protected $guarded = [];
    protected $casts = [
        'unit_price' => 'float',
        'trade_buy_fee' => 'float',
        'trade_sell_fee' => 'float',
        'ts' => 'datetime'
    ];

    public function buy_user()
    {
        return $this->belongsTo(User::class, 'buy_user_id', 'user_id');
    }

    public function sell_user()
    {
        return $this->belongsTo(User::class, 'sell_user_id', 'user_id');
    }

    public function buy_entrust()
    {
        return $this->belongsTo(ContractEntrust::class, 'buy_id', 'id');
    }

    public function sell_entrust()
    {
        return $this->belongsTo(ContractEntrust::class, 'sell_id', 'id');
    }
}
