<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-28 15:28:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-03 16:16:36
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
    //充币

    protected $primaryKey = 'id';
    protected $table = 'user_wallet_recharge';
    protected $guarded = [];

    protected $casts = [
        'amount' => 'real',
        'datetime' => 'datetime'
    ];

    public static $typeMap = [
        1 => '在线',
        2 => '后台',
    ];

    //状态
    const status_wait = 0; //待审核
    const status_pass = 1; //审核通过
    const status_reject = 2; //审核拒绝
    public static $statusMap = [
        self::status_wait => '待审核',
        self::status_pass => '审核通过',
        self::status_reject => '审核拒绝',
    ];


    public static $coinType = [
        1 => "USDT",
        2 => "BTC",
        3 => "ETH",
        4 => "EOS",
        5 => "ETC",
        6 => "EET"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
