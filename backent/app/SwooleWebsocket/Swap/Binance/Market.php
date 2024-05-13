<?php

namespace App\SwooleWebsocket\Swap\Binance;

use App\Models\InsideTradePair;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;

class Market extends Binance
{
    protected static $client;

    // 用于向服务器发送数据
    public static function push()
    {
        self::subscribe(\App\Models\ContractPair::query()
            ->where(['status' => 1])
            ->pluck('symbol')
            ->map(function ($symbol) {
                $symbol = strtolower($symbol) . 'usdt';
                return "{$symbol}@ticker";
            })->toArray());
    }
    // 接受订阅消息
    public static function recv_ch($data)
    {
        $stream = $data['stream'];
        $symbol = strtoupper(substr(str_before($stream, '@'), 0, -4)); //币种名称
        // k线原始数据
        $resdata = $data['data'];
        // 市场概况
        $cache_data = [
            'id' => $resdata['E'], //unix时间戳 13位
            'low' => $resdata['l'], //24小时最低价
            'high' => $resdata['h'], //24小时最高价
            'open' => $resdata['o'], //24小时开盘价
            'close' => $resdata['c'],    //最新价格
            'vol' => $resdata['q'],  //24小时成交额
            'amount' => $resdata['v'], //24小时成交量
        ];

        $risk_key = 'fkJson:' . $symbol . '/USDT';
        $risk = json_decode(Redis::get($risk_key), true);
        $minUnit = $risk['minUnit'] ?? 0;
        $count = $risk['count'] ?? 0;
        $enabled = $risk['enabled'] ?? 0;
        if (!blank($risk) && $enabled == 1) {
            $change = $minUnit * $count;
            $cache_data['close'] = PriceCalculate($cache_data['close'], '+', $change, 8);
            $cache_data['open'] = PriceCalculate($cache_data['open'], '+', $change, 8);
            $cache_data['high'] = PriceCalculate($cache_data['high'], '+', $change, 8);
            $cache_data['low'] = PriceCalculate($cache_data['low'], '+', $change, 8);
        }

        if (isset($cache_data['open']) && $cache_data['open'] != 0) {
            // 获取1dayK线 计算$increase
            $day_kline = Cache::store('redis')->get('swap:' . $symbol . '_kline_' . '1day');
            if (blank($day_kline)) {
                $increase = PriceCalculate(($cache_data['close'] - $cache_data['open']), '/', $cache_data['open'], 4);
            } else {
                $increase = PriceCalculate(($cache_data['close'] - $day_kline['open']), '/', $day_kline['open'], 4);
            }
        } else {
            $increase = 0;
        }
        $cache_data['increase'] = $increase;
        $flag = $increase >= 0 ? '+' : '';
        $cache_data['increaseStr'] = $increase == 0 ? '+0.00%' : $flag . $increase * 100 . '%';

        $key = 'swap:' . $symbol . '_detail';
        Cache::store('redis')->put($key, $cache_data);
    }
    // 接受请求消息
    public static function recv_rep($data)
    {
    }
}
