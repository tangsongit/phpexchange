<?php
require "../../index.php";

use App\Models\Coins;
use App\Models\InsideTradePair;
use App\Models\Mongodb\NewPriceBook;
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
            //最新成交
            $params[] = "{$symbol}@trade";
        }
        $request = [
            "method" => "SUBSCRIBE",
            "params" => $params,
            "id" => time()

        ];
        $con->send(json_encode($request));
    };

    $con->onMessage = function ($con, $data) {
        if (substr(round(microtime(true), 1), -1) % 2 == 0) { //当千分秒为为偶数 则处理数据
            $data =  json_decode($data, true);
            if (isset($data['ping'])) {
                $msg = ["pong" => $data['ping']];
                $con->send(json_encode($msg));
            }
            if (isset($data['stream'])) {
                $stream = $data['stream'];
                $symbol = str_before($stream, '@'); //币种名称

                // k线原始数据
                $resdata = $data['data'];

                $new_price_key = 'market:' . $symbol . '_newPrice';
                $cache_data = [
                    'ts' => $resdata['E'], //成交时间
                    'tradeId' => $resdata['t'], //唯一成交ID
                    'amount' => $resdata['q'], // 成交量(买或卖一方)
                    'price' => floatval($resdata['p']), //成交价
                    'direction'  => $resdata['m'] ? 'sell' : 'buy', //buy/sell 买卖方向
                ];
                // dump(date('Y-m-d H:i:s', $cache_data['ts'] / 1000));

                // TODO 获取Kline数据 计算涨幅
                // $kline_key = 'market:' . $symbol . '_kline_1day';
                // $last_cache_data = Cache::store('redis')->get($kline_key);
                // 计算24小时涨幅
                $kline_book_key = 'market:' . $symbol . '_kline_book_1min';
                $kline_book = Cache::store('redis')->get($kline_book_key);
                $time = time();
                $priv_id = $time - ($time % 60) - 86400; //获取24小时前的分钟线
                if ($kline_book) {
                    $last_cache_data = collect($kline_book)->firstWhere('id', $priv_id);
                }
                if (isset($last_cache_data) && !blank($last_cache_data) && $last_cache_data['open']) {
                    $increase = PriceCalculate(custom_number_format($cache_data['price'] - $last_cache_data['open'], 8), '/', custom_number_format($last_cache_data['open'], 8), 4);
                    $cache_data['increase'] = $increase;
                    $flag = $increase >= 0 ? '+' : '';
                    $cache_data['increaseStr'] = $increase == 0 ? '+0.00%' : $flag . $increase * 100 . '%';
                } else {
                    $cache_data['increase'] = 0;
                    $cache_data['increaseStr'] = '+0.00%';
                }


                $group_id2 = 'tradeList_' . $symbol; //最近成交明细
                if (Gateway::getClientIdCountByGroup($group_id2) > 0) {
                    Gateway::sendToGroup($group_id2, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cache_data, 'sub' => $group_id2, 'type' => 'dynamic']));
                }

                if (!blank($cache_data)) {
                    Cache::store('redis')->put($new_price_key, $cache_data);
                    //缓存历史价格数据book
                    $new_price_book_key = 'market:' . $symbol . '_newPriceBook';
                    $new_price_book = Cache::store('redis')->get($new_price_book_key);
                    if (blank($new_price_book)) {
                        Cache::store('redis')->put($new_price_book_key, [$cache_data]);
                    } else {
                        array_push($new_price_book, $cache_data);
                        if (count($new_price_book) > 200) {
                            array_shift($new_price_book);
                        }
                        Cache::store('redis')->put($new_price_book_key, $new_price_book);
                    }

                    // 缓存历史价格数据book到mongodb
                    //                        $cache_data['symbol'] = $symbol;
                    //                        $cache_data['time'] = time();
                    //                        NewPriceBook::query()->create($cache_data);


                }
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
