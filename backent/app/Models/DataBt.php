<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-09-07 14:58:14
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DataBt extends Model
{
    // 空气币Kline数据

    protected $table = 'data_bt';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;

    public static function getKlineData($symbol, $period, $size)
    {
        $builder = self::query();
        $wheres = [
            '1min' => 'is_1min',
            '5min' => 'is_5min',
            '15min' => 'is_15min',
            '30min' => 'is_30min',
            '60min' => 'is_1h',
            '4hour' => 'is_4hour',
            '1day' => 'is_day',
            '1week' => 'is_week',
            '1mon' => 'is_month',
        ];
        $where = $wheres[$period] ?? 'is_1min';
        $builder->where($where, 1);

        $data = $builder->where('Date', '<', time())->limit($size)->orderByDesc('Date')->get();
        if (blank($data)) return [];
        $data = $data->sortBy('Date')->values()->map(function ($kline) {
            $item = [
                "id" => $kline['Date'],
                "amount" => $kline['Amount'],
                "count" => $kline['Amount'],
                "open" => $kline['Open'],
                "close" => $kline['Close'],
                "low" => $kline['Low'],
                "high" => $kline['High'],
                "vol" => $kline['Volume']
            ];
            $item['price'] = $item['close'];
            return $item;
        })->toArray();
        // 重设数组最后一组数据的值
        $time = time();
        $data = self::getlastData($data, $period, $time);
        return $data;
    }

    /**
     * @description: 获取最新5分钟线 十五分钟线 30分钟线 1小时线 4小时线 1天线 1周线 一月线
     * @param {*}
     * @return {*}
     */
    public static function getlastData($data, $period, $time)
    {
        $periodMap = [
            '1min' => ['column' => 'is_1min', 'seconds' => 60],
            '5min' => ['column' => 'is_5min', 'seconds' => 300],
            '15min' => ['column' => 'is_15min', 'seconds' => 900],
            '30min' => ['column' => 'is_30min', 'seconds' => 1800],
            '60min' => ['column' => 'is_1h', 'seconds' => 3600],
            '4hour' => ['column' => 'is_4hour', 'seconds' => 14400],
            '1day' => ['column' => 'is_day', 'seconds' => 86400],
            '1week' => ['column' => 'is_week', 'seconds' => 604800],
            '1mon' => ['column' => 'is_month', 'seconds' => 18144000],
        ];
        $tmp = $data[array_key_last($data)];
        if ($period == '1mon') {
            $res = self::query()
                ->whereBetween('Date', [\Carbon\Carbon::now()->firstOfMonth()->timestamp, $time])
                ->where('is_1min', 1)
                ->get();
        } else {
            $res = self::query()
                ->whereBetween('Date', [$time - $time % $periodMap[$period]['seconds'], $time])
                ->where('is_1min', 1)
                ->get();
        }
        $data[array_key_last($data)] = [
            "id" => $tmp['id'],
            "amount" => $res->sum('Amount'),
            "count" => $res->sum('Amount'),
            "open" => $res->first()->Open,
            "close" => $res->last()->Close, //最新价
            "low" => $res->min('Low'),
            "high" => $res->max('High'),
            "vol" => $res->sum('Volume'),
            "price" => $res->last()->Close
        ];
        return $data;
    }
}
