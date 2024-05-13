<?php

namespace App\SwooleWebsocket\Spot\Binance;

use Swoole\Coroutine\Http\Client;
use App\Models\InsideTradePair;
use App\SwooleWebsocket\WebsocketGroup;
use Illuminate\Support\Facades\Cache;


class Kline extends Binance
{
    protected static $client;
    public static $periods = [
        '1m' => ['period' => '1min', 'seconds' => 60],
        '5m' => ['period' => '5min', 'seconds' => 300],
        '15m' => ['period' => '15min', 'seconds' => 900],
        '30m' => ['period' => '30min', 'seconds' => 1800],
        '1h' => ['period' => '60min', 'seconds' => 3600],
        '4h' => ['period' => '4hour', 'seconds' => 14400],
        '1d' => ['period' => '1day', 'seconds' => 86400],
        '1w' => ['period' => '1week', 'seconds' => 604800],
        '1M' => ['period' => '1mon', 'seconds' => 2592000],
    ];



    // 向服务器发送数据
    public static function push()
    {
        $symbols = InsideTradePair::query()
            ->where(['status' => 1, 'is_market' => 1])
            ->pluck('symbol')
            ->crossJoin(array_keys(static::$periods))
            ->map(function ($v) {
                $symbol = $v[0];
                $period = $v[1];
                // HTTP请求历史数据
                // $path = '/api/v3/klines?';
                // $params = http_build_query([
                //     'symbol' => strtoupper($symbol),
                //     'interval' => $period,
                //     'limit' => 500
                // ]);
                // $cli =  new Client('api.binance.com', 443, true);
                // $cli->get($path . $params);
                // self::rec_http(json_decode($cli->body, true), $symbol, $period);
                // $cli->close();
                // 订阅K线数据
                return [
                    'symbol' => $symbol,
                    'period' => $period
                ];
            });

        // 订阅K线数据
        self::subscribe($symbols->map(function ($v) {
            return "{$v['symbol']}@kline_{$v['period']}";
        })->toArray());
    }

    public static function rec_http($data, $symbol, $period)
    {
        if (!isset($data['code'])) {
            $symbol = strtolower($symbol);
            $period = static::$periods[$period]['period'];
            $data = collect($data, true)->map(function ($v) {
                return [
                    'id' => round($v['0'] / 1000), //时间戳
                    'open' => $v['1'], //开盘价
                    'close' => $v['4'],    //收盘价
                    'high' => $v['2'], //最高价
                    'low' => $v['3'],  //最低价
                    'amount' => $v['5'],    //成交量(币)
                    'vol' => $v['7'],  //成交额
                    'time' => time(),
                ];
            })->toArray();
            $kline_book_key = 'market:' . $symbol . '_kline_book_' . $period;
            Cache::store('redis')->put($kline_book_key, $data);  //填充历史k线数据
        }
    }
    // 接受订阅消息
    public static function recv_ch($data)
    {
        $stream = $data['stream'];
        $symbol = str_before($stream, '@'); //币种名称
        $period = str_after($stream, '_');
        $seconds = static::$periods[$period]['seconds'];
        $period = static::$periods[$period]['period'];
        $resdata = $data['data']['k'];

        $cache_data = [
            'id' => round($resdata['T'] / 1000), //时间戳
            'open' => $resdata['o'], //开盘价
            'close' => $resdata['c'],    //收盘价
            'high' => $resdata['h'], //最高价
            'low' => $resdata['l'],  //最低价
            'amount' => $resdata['v'],    //成交量(币)
            'vol' => $resdata['q'],  //成交额
            'time' => time(),
        ];

        $kline_book_key = 'market:' . $symbol . '_kline_book_' . $period;
        $kline_book = Cache::store('redis')->get($kline_book_key); //历史k线数据

        if (!blank($kline_book)) { //找到当前k线数据的上一条k线纠正最新数据的开盘价格与上一条数据收盘价格相同
            $prev_id = $cache_data['time'] - $seconds;
            $prev_item = array_last($kline_book, function ($value) use ($prev_id) {
                return $value['id'] == $prev_id;
            });
            if (!empty($prev_item) && $prev_item['close']) {
                $cache_data['open'] = $prev_item['close'];
            }
        }

        Cache::store('redis')->put('market:' . $symbol . '_kline_' . $period, $cache_data);
        if (blank($kline_book)) {
            Cache::store('redis')->put($kline_book_key, [$cache_data]);  //填充历史k线数据
        } else {
            $last_item = array_pop($kline_book); //获取最后一条数据
            if ($last_item['id'] == $cache_data['id']) {
                array_push($kline_book, $cache_data);
            } else {
                array_push($kline_book, $last_item, $cache_data);
            }
            if (count($kline_book) > 2000) {
                array_shift($kline_book);
            }
            Cache::store('redis')->put($kline_book_key, $kline_book);

            // 将k线数据发送到websocket服务端
            $group_id = 'Kline_' . $symbol . '_' . $period;
            WebsocketGroup::sendToGroup($group_id, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cache_data, 'sub' => $group_id, 'type' => 'dynamic']));
        }
    }
    // 接受请求消息
    public static function recv_rep($data)
    {
        $rep = $data['rep'];
        $parrern_kline = '/^market\.(.*?)\.kline\.([\s\S]*)/';  //匹配K线ch
        if (preg_match($parrern_kline, $rep, $match_kline)) {
            $symbol = $match_kline[1];
            $symbol = str_before($symbol, '-');
            $period = $match_kline[2];
            $cache_data = $data['data'];
        }
    }
}
