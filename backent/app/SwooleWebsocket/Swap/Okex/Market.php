<?php

namespace App\SwooleWebsocket\Swap\Okex;

use App\Models\InsideTradePair;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;

class Market extends Okex
{
    protected static $client;

    // 用于向服务器发送数据
    public static function push()
    {
        \App\Models\ContractPair::query()
            ->where(['status' => 1])
            ->pluck('symbol')
            ->map(function ($symbol) {
                $arg = [
                    'channel' => 'tickers',
                    'instId' => $symbol . '-USDT-SWAP'
                ];
                $sub_msg = ["op" => 'subscribe', 'args' => [$arg]];
                self::$client->push(json_encode($sub_msg));
            });
    }
    // 接受订阅消息
    public static function recv_ch($data)
    {
        $arg = $data['arg'];
        $channel = $arg['channel']; //周期
        $instID = $arg['instId'];   //币对

        // k线原始数据
        $resdata = $data['data'][0];
        $symbol = strtoupper(str_before($instID, '-')); //币对

        if ($channel == 'tickers') {
            // 市场概况
            $cache_data = [
                'id' => $resdata['ts'], //unix时间戳 13位
                'low' => $resdata['low24h'], //24小时最低价
                'high' => $resdata['high24h'], //24小时最高价
                'open' => $resdata['open24h'], //24小时开盘价
                'close' => $resdata['last'],    //最新价格
                'vol' => $resdata['volCcy24h'],  //24小时成交额
                'amount' => $resdata['vol24h'], //24小时成交量
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
    }
    // 接受请求消息
    public static function recv_rep($data)
    {
    }
}
