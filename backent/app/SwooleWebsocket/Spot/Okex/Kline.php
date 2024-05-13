<?php

namespace App\SwooleWebsocket\Spot\Okex;

use Swoole\Coroutine\Http\Client;
use App\Models\InsideTradePair;
use App\SwooleWebsocket\WebsocketGroup;
use Illuminate\Support\Facades\Cache;


class Kline extends Okex
{
    protected static $client;
    public static $periods = [
        'candle1m' => ['period' => '1min', 'seconds' => 60],
        'candle5m' => ['period' => '5min', 'seconds' => 300],
        'candle15m' => ['period' => '15min', 'seconds' => 900],
        'candle30m' => ['period' => '30min', 'seconds' => 1800],
        'candle1H' => ['period' => '60min', 'seconds' => 3600],
        'candle4H' => ['period' => '4hour', 'seconds' => 14400],
        'candle1D' => ['period' => '1day', 'seconds' => 86400],
        'candle1W' => ['period' => '1week', 'seconds' => 604800],
        'candle1M' => ['period' => '1mon', 'seconds' => 2592000],
    ];


    // 向服务器发送数据
    public static function push()
    {
        $args = InsideTradePair::query()
            ->where(['status' => 1, 'is_market' => 1])
            ->pluck('pair_name')
            ->crossJoin(array_keys(self::$periods))
            ->map(function ($v) {
                $instId = str_replace('/', '-', $v[0]);
                $channel = $v[1];
                return [
                    'channel' => $channel,
                    'instId' => $instId
                ];
            })->toArray();
        $sub_msg = ["op" => 'subscribe', 'args' => $args];
        self::$client->push(json_encode($sub_msg));
    }

    // 接受订阅消息
    public static function recv_ch($data)
    {
        $arg = $data['arg'];
        $channel = $arg['channel']; //周期
        $instID = $arg['instId'];   //币对

        // k线原始数据
        $resdata = $data['data'][0];
        $symbol = strtolower(str_replace('-', '', $instID)); //币对
        $period = self::$periods[$channel]['period']; //转换为与系统格式一致的周期
        $seconds = self::$periods[$channel]['seconds']; //获取周期秒数

        $cache_data = [
            'id' => round($resdata[0] / 1000), //时间戳
            'open' => $resdata[1], //开盘价
            'close' => $resdata[4],    //收盘价
            'high' => $resdata[2], //最高价
            'low' => $resdata[3],  //最低价
            'amount' => $resdata[5],    //成交量(币)
            'vol' => $resdata[6],  //成交额
            'time' => time(),
            // 'count' => //成交笔数
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
    }
}
