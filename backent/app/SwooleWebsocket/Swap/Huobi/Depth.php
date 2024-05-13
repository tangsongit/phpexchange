<?php

namespace App\SwooleWebsocket\Swap\Huobi;

use App\SwooleWebsocket\WebsocketGroup;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

use function Swoole\Coroutine\run;

class Depth extends Huobi
{
    protected static $client;

    // 用于向服务器发送数据
    public static function push()
    {
        \App\Models\ContractPair::query()
            ->pluck('symbol')
            ->map(function ($symbol) {
                $symbol = $symbol . '-USDT';
                $msg = ["sub" => "market." . $symbol . ".depth.step7.sync", "id" => rand(100000, 999999) . time()];
                self::$client->push(json_encode($msg));
            });
    }
    // 接受订阅消息
    public static function recv_ch($data)
    {
        $ch = $data['ch']; //获取ch
        $pattern_depth = '/^market\.(.*?)\.depth\.step7.sync$/'; //匹配深度正则表达式
        if (preg_match($pattern_depth, $ch, $match_depth)) {
            $symbol = $match_depth[1];
            $symbol = str_before($symbol, '-');

            $risk_key = 'fkJson:' . $symbol . '/USDT';
            $risk = json_decode(Redis::get($risk_key), true);
            $minUnit = $risk['minUnit'] ?? 0;
            $count = $risk['count'] ?? 0;
            $enabled = $risk['enabled'] ?? 0;

            $buyList = $data['tick']['bids'] ?? [];
            $cacheBuyList = [];
            foreach ($buyList as $key1 => $item1) {
                $cacheBuyList[$key1]['id'] = Str::uuid()->toString();
                $cacheBuyList[$key1]['amount'] = $item1[1];
                if (!blank($risk) && $enabled == 1) {
                    // 修改买盘价格
                    $original_price = $item1[0];
                    $tmp = explode('.', $original_price);
                    if (sizeof($tmp) > 1) {
                        $size = strlen(end($tmp));
                    } else {
                        $size = 0;
                    }
                    $change = $minUnit * $count;
                    $cacheBuyList[$key1]['price'] = PriceCalculate($original_price, '+', $change, 8);
                } else {
                    $cacheBuyList[$key1]['price'] = $item1[0];
                }
            }

            $sellList = $data['tick']['asks'] ?? [];
            $cacheSellList = [];
            foreach ($sellList as $key2 => $item2) {
                $cacheSellList[$key2]['id'] = Str::uuid()->toString();
                $cacheSellList[$key2]['amount'] = $item2[1];
                if (!blank($risk) && $enabled == 1) {
                    // 修改卖盘价格
                    $original_price = $item2[0];
                    $tmp = explode('.', $original_price);
                    if (sizeof($tmp) > 1) {
                        $size = strlen(end($tmp));
                    } else {
                        $size = 0;
                    }
                    $change = $minUnit * $count;
                    $cacheSellList[$key2]['price'] = PriceCalculate($original_price, '+', $change, 8);
                } else {
                    $cacheSellList[$key2]['price'] = $item2[0];
                }
            }
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

            WebsocketGroup::sendToGroup($group_id1, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cacheBuyList, 'sub' => $group_id1]));
            WebsocketGroup::sendToGroup($group_id2, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cacheSellList, 'sub' => $group_id2]));
        }
    }
    // 接受请求消息
    public static function recv_rep($data)
    {
    }
}
