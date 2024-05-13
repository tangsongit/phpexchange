<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinData extends Model
{
    // STAI 空气币Kline数据

    protected $table = 'coin_data';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
