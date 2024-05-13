<?php

namespace App\SwooleWebsocket\Spot\Huobi;

use Swoole\Coroutine\Http\Client;
use App\Models\InsideTradePair;
use App\SwooleWebsocket\WebsocketGroup;
use Illuminate\Support\Facades\Cache;


class Kline extends Huobi
{
    protected static $client;
    public static $periods = [
        '1min' => 60,
        '5min' => 300,
        '15min' => 900,
        '30min' => 1800,
        '60min' => 3600,
        '4hour' => 14400,
        '1day' => 86400,
        '1week' => 604800,
        '1mon' => 2592000
    ];

    // 向服务器发送数据
    public static function push()
    {
        InsideTradePair::query()
            ->where(['status' => 1, 'is_market' => 1])
            ->pluck('symbol')
            ->crossJoin(array_keys(self::$periods))
            ->map(function ($v) {
                $symbol = $v[0];
                $period = $v[1];
                $seconds = self::$periods[$period];
                // 订阅K线数据
                $ch = "market." . $symbol . ".kline." . $period;
                $sub_msg = ["sub" => $ch, 'id' => $ch . '_sub_' . time()];
                // 请求K线数据
                $req_msg = ["req" => $ch, 'id' => $ch . '_req_' . time()];
                self::$client->push(json_encode($sub_msg));
                self::$client->push(json_encode($req_msg));
            });
    }

    // 接受订阅消息
    public static function recv_ch($data)
    {
        try {
            $ch = $data['ch'];
            $parrern_kline = '/^market\.(.*?)\.kline\.([\s\S]*)/';  //匹配K线ch
            if (preg_match($parrern_kline, $ch, $match_kline)) {
                $symbol = $match_kline[1];
                $symbol = str_before($symbol, '-');
                $period = $match_kline[2];
                $cache_data = $data['tick'];
                $cache_data['time'] = time();

                $kline_book_key = 'market:' . $symbol . '_kline_book_' . $period;
                $kline_book = Cache::store('redis')->get($kline_book_key) ?? []; //历史k线数据

                $seconds = self::$periods[$period];
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
        } catch (\Exception $e) {
            dump($kline_book, $ch);
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
            $cache_data['time'] = time();
            $kline_book_key = 'market:' . $symbol . '_kline_book_' . $period;
            Cache::store('redis')->put($kline_book_key, $cache_data);  //填充历史k线数据
        }
    }
}
