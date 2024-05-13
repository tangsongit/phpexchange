<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Coins extends Model
{
    //
    protected $table = 'coins';
    protected $primaryKey = 'coin_id';
    protected $guarded = [];

    public static function getCachedCoinOption()
    {
        return Cache::remember('coinOption', 60, function () {
            return self::query()->where('status',1)->pluck('coin_name','coin_id')->toArray();
        });
    }

}
