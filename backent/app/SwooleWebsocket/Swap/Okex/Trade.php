<?php

namespace App\SwooleWebsocket\Swap\Okex;

use App\Models\InsideTradePair;
use App\SwooleWebsocket\WebsocketGroup;
use Illuminate\Support\Facades\Cache;

class Trade extends Okex
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
                    'channel' => 'trades',
                    'instId' => $symbol . '-USDT-SWAP'
                ];
                $sub_msg = ["op" => 'subscribe', 'args' => [$arg]];
                self::$client->push(json_encode($sub_msg));
            });
    }
    // 接受订阅消息
    public static function recv_ch($data)
    {
        $arg = $data['arg'];
        $channel = $arg['channel']; //周期
        $instID = $arg['instId'];   //币对

        // k线原始数据
        $resdata = $data['data'][0];
        $symbol = strtoupper(str_before($instID, '-')); //币对

        if ($channel == 'trades') {
            // 火币最新成交明细 期权最新价格
            $new_price_key = 'market:' . $symbol . '_newPrice';
            $cache_data = [
                // 'id' => ,//全局成交ID
                'ts' => $resdata['ts'], //成交时间
                'tradeId' => $resdata['tradeId'], //唯一成交ID
                'amount' => $resdata['sz'], // 成交量(买或卖一方)
                'price' => $resdata['px'], //成交价
                'direction'  => $resdata['side'], //buy/sell 买卖方向
            ];

            // TODO 获取Kline数据 计算涨幅
            $kline_key = 'swap:' . $symbol . '_kline_1day';
            $last_cache_data = Cache::store('redis')->get($kline_key);
            if (!blank($last_cache_data) && $last_cache_data['open']) {
                $increase = PriceCalculate(custom_number_format($cache_data['price'] - $last_cache_data['open'], 8), '/', custom_number_format($last_cache_data['open'], 8), 4);
                $cache_data['increase'] = $increase;
                $flag = $increase >= 0 ? '+' : '';
                $cache_data['increaseStr'] = $increase == 0 ? '+0.00%' : $flag . $increase * 100 . '%';
            } else {
                $cache_data['increase'] = 0;
                $cache_data['increaseStr'] = '+0.00%';
            }

            $group_id2 = 'swapTradeList_' . $symbol; //最近成交明细
            WebsocketGroup::sendToGroup($group_id2, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cache_data, 'sub' => $group_id2, 'type' => 'dynamic']));

            $trade_detail_key = 'swap:trade_detail_' . $symbol;
            Cache::store('redis')->put($trade_detail_key, $cache_data);

            // 合约止盈止损
            \App\Jobs\TriggerStrategy::dispatch(['symbol' => $symbol, 'realtime_price' => $cache_data['price']])->onQueue('triggerStrategy');

            //缓存历史数据book
            $trade_list_key = 'swap:tradeList_' . $symbol;
            $trade_list = Cache::store('redis')->get($trade_list_key);
            if (blank($trade_list)) {
                Cache::store('redis')->put($trade_list_key, [$cache_data]);
            } else {
                array_push($trade_list, $cache_data);
                if (count($trade_list) > 30) {
                    array_shift($trade_list);
                }
                Cache::store('redis')->put($trade_list_key, $trade_list);
            }
        }
    }
    // 接受请求消息
    public static function recv_rep($data)
    {
    }
}
