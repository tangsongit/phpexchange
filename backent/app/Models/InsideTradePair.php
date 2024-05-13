<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-19 16:44:48
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class InsideTradePair extends Model
{
    // 币币交易交易对

    protected $table = 'inside_trade_pair';
    protected $primaryKey = 'pair_id';
    protected $guarded = [];

    public static function getCachedPairs()
    {
        return Cache::remember('pairs', 60, function () {
            return self::query()->where('status', 1)->orderBy('sort', 'asc')->get()->groupBy('quote_coin_name')->toArray();
        });
    }
    // 获取可用交易对（不分组）
    public static function getCachedPairs1()
    {
        return Cache::remember('pairs1', 60, function () {
            return self::query()->where('status', 1)->orderBy('sort', 'asc')->get()->toArray();
        });
    }

    public function can_store()
    {
        if ($this->trade_status == 0) {
            return '交易暂时关闭';
        }
        return true;
    }
}
