<?php
require "../../index.php";

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Workerman\Connection\AsyncTcpConnection;
use Workerman\Lib\Timer;
use Workerman\Worker;
use GatewayWorker\Lib\Gateway;

$worker = new Worker();
$worker->count = 1;
$worker->onWorkerStart = function ($worker) {

    Gateway::$registerAddress = '127.0.0.1:1238';

    $http = new Workerman\Http\Client();
    //所有交易对
    $symbols = \App\Models\ContractPair::query()->where('status', 1)->pluck('symbol');
    $period = '30m';
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
            'pair' => strtoupper($symbol) . 'USDT',
            'contractType' => 'PERPETUAL',
            'interval' => $period,
            'limit' => 1500
        ]);
        $http_url = 'http://fapi.binance.com/fapi/v1/continuousKlines?' . $params;
        $http->get($http_url, function ($response) use ($symbol, $period, $periods) {
            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true);
                $kline_book_key = 'swap:' . $symbol . '_kline_book_' . $periods[$period]['period'];
                if (is_array($data)) {
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
                        if ($v['id'] > time()) return true;
                    })->toArray();
                    Cache::store('redis')->put($kline_book_key, $cache_data);
                }
            }
        }, function ($exception) {
            info($exception);
        });
    }

    $con = new AsyncTcpConnection('ws://fstream.binance.com/stream');

    // 设置以ssl加密方式访问，使之成为wss
    $con->transport = 'ssl';

    $con->onConnect = function ($con) use ($period, $symbols) {
        $params = [];
        foreach ($symbols as $symbol) {
            // Kline数据
            $symbol = strtolower($symbol) . 'usdt';
            $params[] = "{$symbol}@kline_{$period}";
        }
        $request = [
            "method" => "SUBSCRIBE",
            "params" => $params,
            "id" => time()

        ];
        $con->send(json_encode($request));
    };

    $con->onMessage = function ($con, $data) use ($periods) {
        if (substr(round(microtime(true), 1), -1) % 2 == 0) { //当千分秒为为偶数 则处理数据
        $data =  json_decode($data, true);
        if (isset($data['ping'])) {
            $msg = ["pong" => $data['ping']];
            $con->send(json_encode($msg));
        } else {
            if (isset($data['stream'])) {
                $stream = $data['stream'];
                $symbol = strtoupper(substr(str_before($stream, '@'), 0, -4)); //币种名称
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

                    $kline_book_key = 'swap:' . $symbol . '_kline_book_' . $period;
                    $kline_book = Cache::store('redis')->get($kline_book_key);

                    // 获取风控任务
                    $risk_key = 'fkJson:' . $symbol . '/USDT';
                    $risk = json_decode(Redis::get($risk_key), true);
                    $minUnit = $risk['minUnit'] ?? 0;
                    $count = $risk['count'] ?? 0;
                    $enabled = $risk['enabled'] ?? 0;
                    if (!blank($risk) && $enabled == 1) {
                        // 修改价格
                        $change = $minUnit * $count;
                        $cache_data['close']    = PriceCalculate($cache_data['close'], '+', $change, 8);
                        $cache_data['open']     = PriceCalculate($cache_data['open'], '+', $change, 8);
                        $cache_data['high']     = PriceCalculate($cache_data['high'], '+', $change, 8);
                        $cache_data['low']      = PriceCalculate($cache_data['low'], '+', $change, 8);
                    }

                    if ($period == '1min') {
                        // 1分钟基线
                        if (!blank($kline_book)) { //矫正K先开盘价
                            $prev_id = $cache_data['id'] - $seconds;
                            $prev_item = array_last($kline_book, function ($value, $key) use ($prev_id) {
                                return $value['id'] == $prev_id;
                            });
                            $cache_data['open'] = $prev_item['close'];
                        }

                        if (blank($kline_book)) {
                            Cache::store('redis')->put($kline_book_key, [$cache_data]);
                        } else {
                            $last_item1 = array_pop($kline_book); //弹出数据最后一个值
                            if ($last_item1['id'] == $cache_data['id']) {
                                array_push($kline_book, $cache_data);
                            } else {
                                array_push($kline_book, $last_item1, $cache_data);
                            }

                            if (count($kline_book) > 3000) {
                                array_shift($kline_book);
                            }
                            Cache::store('redis')->put($kline_book_key, $kline_book);
                        }
                    } else {
                        // 其他长周期K线都以前一周期作为参考 比如5minK线以1min为基础
                        $periodMap = [
                            '5min' => ['period' => '1min', 'seconds' => 60],
                            '15min' => ['period' => '5min', 'seconds' => 300],
                            '30min' => ['period' => '15min', 'seconds' => 900],
                            '60min' => ['period' => '30min', 'seconds' => 1800],
                            '4hour' => ['period' => '60min', 'seconds' => 3600],
                            '1day' => ['period' => '4hour', 'seconds' => 14400],
                            '1week' => ['period' => '1week', 'seconds' => 86400],
                            '1mon' => ['period' => '1mon', 'seconds' => 604800],
                        ];
                        $map = $periodMap[$period] ?? null;
                        $kline_base_book = Cache::store('redis')->get('swap:' . $symbol . '_kline_book_' . $map['period']);
                        if (!blank($kline_base_book)) {
                            // 以5min周期为例 这里一次性取出1min周期前后10个
                            // $first_item_id = $cache_data['id'];
                            // $last_item_id = $cache_data['id'] + $seconds - $map['seconds'];
                            // $items1 = array_where($kline_base_book, function ($value, $key) use ($first_item_id, $last_item_id) {
                            //     return $value['id'] >= $first_item_id && $value['id'] <= $last_item_id;
                            // });

                            // if (!blank($items1)) {
                            //     $cache_data['open']     = array_first($items1)['open'] ?? $cache_data['open'];
                            //     $cache_data['close']    = array_last($items1)['close'] ?? $cache_data['close'];
                            //     $cache_data['high']     = max(array_pluck($items1, 'high')) ?? $cache_data['high'];
                            //     $cache_data['low']      = min(array_pluck($items1, 'low')) ?? $cache_data['low'];
                            // }

                            if (blank($kline_book)) {
                                Cache::store('redis')->put($kline_book_key, [$cache_data]);
                            } else {
                                $last_item1 = array_pop($kline_book);
                                if ($last_item1['id'] == $cache_data['id']) {
                                    array_push($kline_book, $cache_data);
                                } else {
                                    $update_last_item1 = $last_item1;
                                    // 有新的周期K线生成 此时尝试更新$last_item1
                                    $first_item_id2 = $cache_data['id'] - $seconds;
                                    $last_item_id2 = $cache_data['id'] - $map['seconds'];
                                    $items2 = array_where($kline_base_book, function ($value, $key) use ($first_item_id2, $last_item_id2) {
                                        return $value['id'] >= $first_item_id2 && $value['id'] <= $last_item_id2;
                                    });
                                    if (!blank($items2)) {
                                        $update_last_item1['open']     = array_first($items2)['open'] ?? $update_last_item1['open'];
                                        $update_last_item1['close']    = array_last($items2)['close'] ?? $update_last_item1['close'];
                                        $update_last_item1['high']     = max(array_pluck($items2, 'high')) ?? $update_last_item1['high'];
                                        $update_last_item1['low']      = min(array_pluck($items2, 'low')) ?? $update_last_item1['low'];
                                    }
                                    array_push($kline_book, $update_last_item1, $cache_data);
                                }
                                if (count($kline_book) > 3000) {
                                    array_shift($kline_book);
                                }
                                Cache::store('redis')->put($kline_book_key, $kline_book);
                            }
                        }
                    }

                    Cache::store('redis')->put('swap:' . $symbol . '_kline_' . $period, $cache_data);

                    $group_id2 = 'swapKline_' . $symbol . '_' . $period;
                    if (Gateway::getClientIdCountByGroup($group_id2) > 0) {
                        Gateway::sendToGroup($group_id2, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cache_data, 'sub' => $group_id2, 'type' => 'dynamic']));
                    }
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
