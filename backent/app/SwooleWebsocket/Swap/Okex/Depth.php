<?php

namespace App\SwooleWebsocket\Swap\Okex;

use App\Models\InsideTradePair;
use App\SwooleWebsocket\WebsocketGroup;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


class Depth extends Okex
{
    protected static $client;
    // 用于向服务器发送数据
    public static function push()
    {

        \App\Models\ContractPair::query()
            ->where(['status' => 1])
            ->pluck('symbol')
            ->map(function ($symbol) {
                $arg = [
                    'channel' => 'books',
                    'instId' => $symbol . '-USDT-SWAP'
                ];
                $sub_msg = ["op" => 'subscribe', 'args' => [$arg]];
                self::$client->push(json_encode($sub_msg));
            })->toArray();
    }
    // 接受订阅消息
    public static function recv_ch($data)
    {

        $arg = $data['arg'];
        $instID = $arg['instId'];   //币对
        $symbol = strtoupper(str_before($instID, '-')); //币对
        if (isset($data['action']) && $data['action'] == 'update') { //如果接受到增量数据
            $cacheBuyList = collect($data['data'][0]['bids'] ?? [])->map(function ($item) {
                return [
                    'id' => (string)Str::uuid(),
                    'amount' => $item[1],
                    'price' => $item[0]
                ];
            })->toArray(); //缓存买入列表

            $cacheSellList = collect($data['data'][0]['asks'] ?? [])->map(function ($item) {
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
    }
    // 接受请求消息
    public static function recv_rep($data)
    {
    }
}
