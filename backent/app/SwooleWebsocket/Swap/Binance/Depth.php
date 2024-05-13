<?php

namespace App\SwooleWebsocket\Swap\Binance;

use App\Models\InsideTradePair;
use App\SwooleWebsocket\WebsocketGroup;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


class Depth extends Binance
{
    protected static $client;
    // 用于向服务器发送数据
    public static function push()
    {

        self::subscribe(\App\Models\ContractPair::query()
            ->where(['status' => 1])
            ->pluck('symbol')
            ->map(function ($symbol) {
                $symbol = strtolower($symbol);
                return "{$symbol}usdt@depth20@500ms";
            })->toArray());
    }
    // 接受订阅消息
    public static function recv_ch($data)
    {

        $stream = $data['stream'];
        $symbol = strtoupper(substr(str_before($stream, '@'), 0, -4)); //币种名称
        $cacheBuyList = collect($data['data']['b'] ?? [])->map(function ($item) {
            return [
                'id' => (string)Str::uuid(),
                'amount' => $item[1],
                'price' => $item[0]
            ];
        })->toArray(); //缓存买入列表

        $cacheSellList = collect($data['data']['a'] ?? [])->map(function ($item) {
            return [
                'id' => (string)Str::uuid(),
                'amount' => $item[1],
                'price' => $item[0]
            ];
        })->toArray(); //缓存卖出列表
        Cache::store('redis')->put('swap:' . $symbol . '_depth_buy', $cacheBuyList);  //将买盘缓存到redis中
        Cache::store('redis')->put('swap:' . $symbol . '_depth_sell', $cacheSellList);    //将卖盘缓存到redis中

        if ($exchange_buy = Cache::store('redis')->get('swap_buyList_' . $symbol)) {
            Cache::store('redis')->forget('exchange_buyList_' . $symbol);
            array_unshift($cacheBuyList, $exchange_buy);
        }
        if ($exchange_sell = Cache::store('redis')->get('swap_sellList_' . $symbol)) {
            Cache::store('redis')->forget('swap_sellList_' . $symbol);
            array_unshift($cacheSellList, $exchange_sell);
        }

        $group_id1 = 'swapBuyList_' . $symbol;
        $group_id2 = 'swapSellList_' . $symbol;
        WebsocketGroup::sendToGroup($group_id1, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cacheBuyList, 'sub' => $group_id1]));
        WebsocketGroup::sendToGroup($group_id2, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cacheSellList, 'sub' => $group_id2]));
    }
    // 接受请求消息
    public static function recv_rep($data)
    {
    }
}
