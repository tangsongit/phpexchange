<?php

namespace App\SwooleWebsocket\Spot\Binance;

use App\Models\InsideTradePair;
use App\SwooleWebsocket\WebsocketGroup;
use Hhxsv5\LaravelS\Swoole\Process\CustomProcessInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Swoole\Coroutine\Http\Client;
use Swoole\Coroutine;
use Swoole\Http\Server;
use Swoole\Process;


class Depth extends Binance
{

    protected static $client;

    // 用于向服务器发送数据
    public static function push()
    {
        self::subscribe(InsideTradePair::query()
            ->where(['status' => 1, 'is_market' => 1])
            ->orderBy('sort', 'asc')
            ->pluck('symbol')
            ->map(function ($symbol) {
                return "{$symbol}@depth10@1000ms";
            })->toArray());
    }
    // 接受订阅消息
    public static function recv_ch($data)
    {
        $stream = $data['stream'];
        $symbol = str_before($stream, '@'); //币种名称
        $cacheBuyList = collect($data['data']['bids'] ?? [])->map(function ($item) {
            return [
                'id' => (string)Str::uuid(),
                'amount' => $item[1],
                'price' => $item[0]
            ];
        })->toArray(); //缓存买入列表
        $cacheSellList = collect($data['data']['asks'] ?? [])->map(function ($item) {
            return [
                'id' => (string)Str::uuid(),
                'amount' => $item[1],
                'price' => $item[0]
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
        WebsocketGroup::sendToGroup($group_id1, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cacheBuyList, 'sub' => $group_id1]));
        WebsocketGroup::sendToGroup($group_id2, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cacheSellList, 'sub' => $group_id2]));
    }
    // 接受请求消息
    public static function recv_rep($data)
    {
    }
}
