<?php
require "../../index.php";

use App\Models\Coins;
use App\Models\InsideTradePair;
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

    $con = new AsyncTcpConnection('ws://stream.binance.com/stream');

    // 设置以ssl加密方式访问，使之成为wss
    $con->transport = 'ssl';

    $con->onConnect = function ($con) {

        //所有交易对
        $symbols = InsideTradePair::query()->where('status', 1)->where('is_market', 1)->orderBy('sort', 'asc')->pluck('symbol')->toArray();
        $params = [];
        foreach ($symbols as $symbol) {
            //买卖盘深度数据
            $params[] = "{$symbol}@depth10@1000ms";
        }
        $request = [
            "method" => "SUBSCRIBE",
            "params" => $params,
            "id" => time()

        ];
        $con->send(json_encode($request));
    };

    $con->onMessage = function ($con, $data) {
        $data =  @json_decode($data, true);

        if (isset($data['ping'])) {
            $msg = ["pong" => $data['ping']];
            $con->send(json_encode($msg));
        }
        if (isset($data['stream'])) {
            $stream = $data['stream'];
            $symbol = str_before($stream, '@'); //币种名称
            $cacheBuyList = collect($data['data']['bids'] ?? [])->map(function ($item) {
                return [
                    'id' => (string)Str::uuid(),
                    'amount' => floatval($item[1]),
                    'price' => floatval($item[0])
                ];
            })->toArray(); //缓存买入列表
            $cacheSellList = collect($data['data']['asks'] ?? [])->map(function ($item) {
                return [
                    'id' => (string)Str::uuid(),
                    'amount' => floatval($item[1]),
                    'price' => floatval($item[0])
                ];
            })->toArray(); //缓存卖出列表
            Cache::store('redis')->put('market:' . $symbol . '_depth_buy', $cacheBuyList);  //将买盘缓存到redis中
            Cache::store('redis')->put('market:' . $symbol . '_depth_sell', $cacheSellList);    //将卖盘缓存到redis中

            if ($exchange_buy = Cache::store('redis')->get('exchange_buyList_' . $symbol)) {
                Cache::store('redis')->forget('exchange_buyList_' . $symbol);
                array_unshift($cacheBuyList, $exchange_buy);
            }
            if ($exchange_sell = Cache::store('redis')->get('exchange_sellList_' . $symbol)) {
                Cache::store('redis')->forget('exchange_sellList_' . $symbol);
                array_unshift($cacheSellList, $exchange_sell);
            }
            $group_id1 = 'buyList_' . $symbol;
            $group_id2 = 'sellList_' . $symbol;
            if (Gateway::getClientIdCountByGroup($group_id1) > 0) {
                Gateway::sendToGroup($group_id1, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cacheBuyList, 'sub' => $group_id1]));
                Gateway::sendToGroup($group_id2, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cacheSellList, 'sub' => $group_id2]));
            }
        }
    };

    $con->onClose = function ($con) {
        if (isset($con->timer_id)) {
            //删除定时器
            Timer::del($con->timer_id);
        }
        //这个是延迟断线重连，当服务端那边出现不确定因素，比如宕机，那么相对应的socket客户端这边也链接不上，那么可以吧1改成适当值，则会在多少秒内重新，我也是1，也就是断线1秒重新链接
        $con->reConnect(1);
    };

    $con->onError = function ($con, $code, $msg) {
        echo "error $code $msg\n";
    };

    $con->connect();
};

Worker::runAll();
