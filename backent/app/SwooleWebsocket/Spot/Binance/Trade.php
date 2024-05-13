<?php

namespace App\SwooleWebsocket\Spot\Binance;

use Swoole\Coroutine\Http\Client;
use Dcat\Admin\Grid\Filter\Where;
use App\Models\InsideTradePair;
use App\SwooleWebsocket\WebsocketGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Swoole\Coroutine;
use Hhxsv5\LaravelS\Swoole\Process\CustomProcessInterface;
use Swoole\Http\Server;
use Swoole\Process;

class Trade extends Binance implements CustomProcessInterface
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
                return "{$symbol}@trade";
            })->toArray());
    }
    // 接受订阅消息
    public static function recv_ch($data)
    {
        $stream = $data['stream'];
        $symbol = str_before($stream, '@'); //币种名称

        // k线原始数据
        $resdata = $data['data'];

        $new_price_key = 'market:' . $symbol . '_newPrice';
        $cache_data = [
            'ts' => $resdata['E'], //成交时间
            'tradeId' => $resdata['t'], //唯一成交ID
            'amount' => $resdata['q'], // 成交量(买或卖一方)
            'price' => $resdata['p'], //成交价
            'direction'  => $resdata['m'] ? 'sell' : 'buy', //buy/sell 买卖方向
        ];

        // TODO 获取Kline数据 计算涨幅
        $kline_key = 'market:' . $symbol . '_kline_1day';
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
        }

        $group_id = 'tradeList_' . $symbol; //最近成交明细
        WebsocketGroup::sendToGroup($group_id, json_encode(['code' => 0, 'msg' => 'success', 'data' => $cache_data, 'sub' => $group_id, 'type' => 'dynamic']));
    }
    // 接受请求消息
    public static function recv_rep($data)
    {
    }
}
