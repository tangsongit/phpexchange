<?php

namespace App\Models\Otc;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\UserAuth;

class OtcAccount extends Model
{
    //

    protected $table = 'otc_account';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function user_auth()
    {
        return $this->hasOne(UserAuth::class, 'user_id', 'user_id');
    }

    public static function getUserWallet($user_id)
    {
        return self::query()
            ->where('user_id', $user_id)
            ->get(['user_id', 'coin_name', 'usable_balance', 'freeze_balance'])
            ->toArray();
    }
}
