<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-10-17 17:00:24
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-10-28 21:20:13
 */
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
            //买卖盘深度数据
            $symbol = strtolower($symbol);
            $params[] = "{$symbol}usdt@depth20@500ms";
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


            // 获取风控任务
            $risk_key = 'fkJson:' . $symbol . '/USDT';
            $risk = json_decode(Redis::get($risk_key), true);
            $minUnit = $risk['minUnit'] ?? 0;
            $count = $risk['count'] ?? 0;
            $enabled = $risk['enabled'] ?? 0;

            $cacheBuyList = collect($data['data']['b'] ?? [])->map(function ($item) use ($risk, $enabled, $minUnit, $count) {
                if (!blank($risk) && $enabled == 1) {
                    // 修改买盘价格
                    $original_price = $item[0];
                    $tmp = explode('.', $original_price);
                    if (sizeof($tmp) > 1) {
                        $size = strlen(end($tmp));
                    } else {
                        $size = 0;
                    }
                    $change = $minUnit * $count;
                    $price = PriceCalculate($original_price, '+', $change, 8);
                } else {
                    $price = $item[0];
                }
                return [
                    'id' => (string)Str::uuid(),
                    'amount' => $item[1],
                    'price' => $price
                ];
            })->toArray(); //缓存买入列表

            $cacheSellList = collect($data['data']['a'] ?? [])->map(function ($item) use ($risk, $enabled, $minUnit, $count) {
                if (!blank($risk) && $enabled == 1) {
                    // 修改买盘价格
                    $original_price = $item[0];
                    $tmp = explode('.', $original_price);
                    if (sizeof($tmp) > 1) {
                        $size = strlen(end($tmp));
                    } else {
                        $size = 0;
                    }
                    $change = $minUnit * $count;
                    $price = PriceCalculate($original_price, '+', $change, 8);
                } else {
                    $price = $item[0];
                }
                return [
                    'id' => (string)Str::uuid(),
                    'amount' => $item[1],
                    'price' => $price
                ];
            })->toArray(); //缓存卖出列表
            Cache::store('redis')->put('swap:' . $symbol . '_depth_buy', $cacheBuyList);
            Cache::store('redis')->put('swap:' . $symbol . '_depth_sell', $cacheSellList);

            if ($swap_buy = Cache::store('redis')->get('swap_buyList_' . $symbol)) {
                Cache::store('redis')->forget('swap_buyList_' . $symbol);
                array_unshift($cacheBuyList, $swap_buy);
            }
            if ($swap_sell = Cache::store('redis')->get('swap_sellList_' . $symbol)) {
                Cache::store('redis')->forget('swap_sellList_' . $symbol);
                array_unshift($cacheSellList, $swap_sell);
            }
            $group_id1 = 'swapBuyList_' . $symbol;
            $group_id2 = 'swapSellList_' . $symbol;
            if (Gateway::getClientIdCountByGroup($group_id1) > 0) {
                Gateway::sendToGroup($group_id1, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cacheBuyList, 'sub' => $group_id1]));
                Gateway::sendToGroup($group_id2, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cacheSellList, 'sub' => $group_id2]));
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
