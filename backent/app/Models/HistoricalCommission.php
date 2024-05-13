<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:41:17
 */

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/8
 * Time: 15:31
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricalCommission extends Model
{
    #合约历史委托
    protected $primaryKey = 'id';
    protected $table = 'contract_historical_commission';
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
