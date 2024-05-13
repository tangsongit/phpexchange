<?php
require "../../index.php";

use App\Models\Coins;
use App\Models\InsideTradePair;
use App\Models\Mongodb\KlineBook;
use App\Models\OptionPair;
use App\Models\OptionScene;
use App\Models\OptionTime;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Workerman\Connection\AsyncTcpConnection;
use Workerman\Lib\Timer;
use Workerman\Worker;
use GatewayWorker\Lib\Gateway;
use Illuminate\Support\Facades\Redis;

$worker = new Worker();
$worker->count = 1;
$worker->onWorkerStart = function ($worker) {

    Gateway::$registerAddress = '127.0.0.1:1236';

    $http = new Workerman\Http\Client();
    $symbols = InsideTradePair::query()->where('status', 1)->where('is_market', 1)->pluck('symbol')->toArray();
    $period = '1w'; //周线
    $periods = [
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
    foreach ($symbols as $symbol) {
        $params = http_build_query([
            'symbol' => strtoupper($symbol),
            'interval' => $period,
            'limit' => 1500
        ]);
        $http_url = 'https://api.binance.com/api/v3/klines?' . $params;
        $http->get($http_url, function ($response) use ($symbol, $period, $periods) {
            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true);
                $kline_book_key = 'market:' . $symbol . '_kline_book_' . $periods[$period]['period'];
                if (is_array($data)) {
                    // $data = array_reverse($data);
                    $cache_data = collect($data, true)->map(function ($v) {
                        return [
                            'id' => intval($v['0'] / 1000), //时间戳
                            'open' => floatval($v['1']), //开盘价
                            'close' => floatval($v['4']),    //收盘价
                            'high' => floatval($v['2']), //最高价
                            'low' => floatval($v['3']),  //最低价
                            'amount' => floatval($v['5']),    //成交量(币)
                            'vol' => floatval($v['7']),  //成交额
                            'time' => time(),
                        ];
                    })->reject(function ($v) {
                        if ($v['id'] > time()) return 1;
                    })->toArray();
                    Cache::store('redis')->put($kline_book_key, $cache_data);
                }
            }
        }, function ($exception) {
            info($exception);
        });
    }

    $con = new AsyncTcpConnection('ws://stream.binance.com/stream');

    // 设置以ssl加密方式访问，使之成为wss
    $con->transport = 'ssl';

    $con->onConnect = function ($con) use ($symbols, $period) {

        $params = [];
        //所有交易对
        foreach ($symbols as $symbol) {
            // Kline数据
            $params[] =  "{$symbol}@kline_{$period}";
        }
        $request = [
            "method" => "SUBSCRIBE",
            "params" => $params,
            "id" => time()

        ];
        $con->send(json_encode($request));
    };

    $con->onMessage = function ($con, $data) use ($periods) {
        $data =  json_decode($data, true);
        if (isset($data['ping'])) {
            $msg = ["pong" => $data['ping']];
            $con->send(json_encode($msg));
        } else {
            if (isset($data['stream'])) {
                $stream = $data['stream'];
                $symbol = str_before($stream, '@'); //币种名称
                $period = str_after($stream, '_');
                $seconds = $periods[$period]['seconds'];
                $period = $periods[$period]['period'];
                $resdata = $data['data']['k'];

                $cache_data = [
                    'id' => intval($resdata['t'] / 1000), //时间戳
                    'open' => floatval($resdata['o']), //开盘价
                    'close' => floatval($resdata['c']),    //收盘价
                    'high' => floatval($resdata['h']), //最高价
                    'low' => floatval($resdata['l']),  //最低价
                    'amount' => floatval($resdata['v']),    //成交量(币)
                    'vol' => floatval($resdata['q']),  //成交额
                    'time' => time(),
                ];
                if ($cache_data['id']  <= time() + 1) {
                    $kline_book_key = 'market:' . $symbol . '_kline_book_' . $period;
                    $kline_book = Cache::store('redis')->get($kline_book_key); //历史k线数据


                    if (!blank($kline_book)) {
                        $prev_id = $cache_data['id'] - $seconds;
                        $prev_item = array_last($kline_book, function ($value, $key) use ($prev_id) {
                            return $value['id'] == $prev_id;
                        });
                        if (!empty($prev_item) && $prev_item['close']) $cache_data['open'] = $prev_item['close'];
                    }

                    Cache::store('redis')->put('market:' . $symbol . '_kline_' . $period, $cache_data);

                    if (blank($kline_book)) {
                        Cache::store('redis')->put($kline_book_key, [$cache_data]);
                    } else {
                        $last_item1 = array_pop($kline_book);
                        if ($last_item1['id'] == $cache_data['id']) {
                            array_push($kline_book, $cache_data);
                        } else {
                            array_push($kline_book, $last_item1, $cache_data);
                        }

                        if (count($kline_book) > 2000) {
                            array_shift($kline_book);
                        }
                        Cache::store('redis')->put($kline_book_key, $kline_book);
                    }

                    // 缓存kline历史数据到mongodb
                    //                $cache_data['key'] = 'Kline_' . $symbol . '_' . $period;
                    //                $cache_data['time'] = time();
                    //                KlineBook::query()->updateOrCreate(['id' => $cache_data['id'],'key' => 'Kline_' . $symbol . '_' . $period],array_except($cache_data,['id','key']));

                    $group_id2 = 'Kline_' . $symbol . '_' . $period;
                    if (Gateway::getClientIdCountByGroup($group_id2) > 0) {
                        Gateway::sendToGroup($group_id2, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cache_data, 'sub' => $group_id2, 'type' => 'dynamic']));
                    }
                }
            }
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
