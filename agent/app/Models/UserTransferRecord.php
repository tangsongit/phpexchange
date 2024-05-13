<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-28 15:28:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-03 18:54:19
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserTransferRecord extends Model
{

    protected $table = 'user_transfer_record';
    public $timestamps = false;
    protected $casts = [
        'datetime' => 'datetime'
    ];

    const status = 1;
    const state = 2;
    static $statusMap = [
        self::status => "成功",
        self::state => "失败",
    ];

    public static $accountMap = [
        'UserWallet' => '账户资产',
        'ContractAccount' => '合约账户',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
