<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-28 15:28:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-13 17:33:48
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    //

    protected $primaryKey = 'wallet_id';
    protected $table = 'user_wallet';
    protected $guarded = [];

    protected $attributes = [
        'usable_balance' => 0,
        'freeze_balance' => 0,
    ];

    public static $richMap = [
        'usable_balance' => '可用余额',
        'freeze_balance' => '冻结余额',
    ];

    const asset_account = 1;
    const sustainable_account = 2;
    public static $accountMap = [
        ['id' => self::asset_account, 'name' => '账户资产', 'model' => UserWallet::class],
        ['id' => self::sustainable_account, 'name' => '合约账户', 'model' => SustainableAccount::class],
    ];

    public function getRichMap()
    {
        return self::$richMap;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public static function getUserWallet($user_id)
    {
        return self::query()
            ->where('user_id', $user_id)
            ->get(['user_id', 'coin_name', 'usable_balance', 'freeze_balance'])
            ->toArray();
    }
}
