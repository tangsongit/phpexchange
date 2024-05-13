<?php
require "../../index.php";

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Workerman\Connection\AsyncTcpConnection;
use Workerman\Lib\Timer;
use Workerman\Worker;
use GatewayWorker\Lib\Gateway;

$worker = new Worker();
$worker->count = 1;
$worker->onWorkerStart = function ($worker) {

    Gateway::$registerAddress = '127.0.0.1:1238';

    $con = new AsyncTcpConnection('ws://fstream.binance.com/stream');

    // 设置以ssl加密方式访问，使之成为wss
    $con->transport = 'ssl';

    $con->onConnect = function ($con) {
        //所有交易对
        $symbols = \App\Models\ContractPair::query()->where('status', 1)->pluck('symbol');
        $params = [];
        foreach ($symbols as $symbol) {
            $symbol = strtolower($symbol) . 'usdt';
            //市场概要
            $params[] = "{$symbol}@ticker";
        }
        $request = [
            "method" => "SUBSCRIBE",
            "params" => $params,
            "id" => time()

        ];
        $con->send(json_encode($request));
    };

    $con->onMessage = function ($con, $data) {
        $data =  json_decode($data, true);
        if (isset($data['ping'])) {
            $msg = ["pong" => $data['ping']];
            $con->send(json_encode($msg));
        }
        if (isset($data['stream'])) {
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

            // 获取风控任务
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
                // // 获取1dayK线 计算$increase
                // $day_kline = Cache::store('redis')->get('swap:' . $symbol . '_kline_' . '1day');
                // if (blank($day_kline)) {
                //     $increase = PriceCalculate(($cache_data['close'] - $cache_data['open']), '/', $cache_data['open'], 4);
                // } else {
                //     $increase = PriceCalculate(($cache_data['close'] - $day_kline['open']), '/', $day_kline['open'], 4);
                // }

                // 获取24小时前的分钟线  计算$increase 
                $kline_book_key = 'swap:' . $symbol . '_kline_book_1min';
                $kline_book = Cache::store('redis')->get($kline_book_key);
                $time = time();
                $priv_id = $time - ($time % 60) - 86400; //获取24小时前的分钟线
                if ($kline_book) {
                    $last_cache_data = collect($kline_book)->firstWhere('id', $priv_id);
                }
                if (!isset($last_cache_data) || blank($last_cache_data)) {
                    $increase = round(($cache_data['close'] - $cache_data['open']) / $cache_data['open'], 4);
                } else {
                    $increase = round(($cache_data['close'] - $last_cache_data['open']) / $last_cache_data['open'], 4);
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
    };

    $con->onClose = function ($con) {
        //这个是延迟断线重连，当服务端那边出现不确定因素，比如宕机，那么相对应的socket客户端这边也链接不上，那么可以吧1改成适当值，则会在多少秒内重新，我也是1，也就是断线1秒重新链接
        $con->reConnect(1);
    };

    $con->onError = function ($con, $code, $msg) {
        echo "error $code $msg\n";
    };

    $con->connect();
};

Worker::runAll();
