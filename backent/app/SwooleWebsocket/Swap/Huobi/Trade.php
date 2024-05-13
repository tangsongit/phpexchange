<?php

namespace App\SwooleWebsocket\Swap\Huobi;

use App\SwooleWebsocket\WebsocketGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Hhxsv5\LaravelS\Swoole\Process\CustomProcessInterface;
use Illuminate\Support\Facades\Redis;


class Trade extends Huobi implements CustomProcessInterface
{
    protected static $client;

    // 用于向服务器发送数据
    public static function push()
    {
        \App\Models\ContractPair::query()
            ->where(['status' => 1])
            ->pluck('symbol')
            ->map(function ($symbol) {
                $symbol = $symbol . '-USDT';
                $ch = "market." . $symbol . ".trade.detail";
                $sub_msg = ["sub" => $ch, "zip" => 1];
                $req_msg = ["req" => $ch, "zip" => 1, 'size' => 30];
                self::$client->push(json_encode($sub_msg));
                self::$client->push(json_encode($req_msg));
            });
    }
    // 接受订阅消息
    public static function recv_ch($data)
    {
        $ch = $data['ch'];
        $pattern_detail = '/^market\.(.*?)\.detail$/'; //市场概要
        if (preg_match($pattern_detail, $ch, $match_detail)) {
            $match = $match_detail[1];
            $symbol = str_before($match, '.');
            $symbol = str_before($symbol, '-');
            $after = str_after($match, '.');
            if ($after == 'trade') {
                // 火币最新成交明细
                // 最新成交价格数据
                $cache_data = $data['tick']['data'][0] ?? [];
                if (blank($cache_data)) return;
                $cache_data['ts'] = Carbon::now()->getPreciseTimestamp(3);

                // 获取风控任务
                $risk_key = 'fkJson:' . $symbol . '/USDT';
                $risk = json_decode(Redis::get($risk_key), true);
                $minUnit = $risk['minUnit'] ?? 0;
                $count = $risk['count'] ?? 0;
                $enabled = $risk['enabled'] ?? 0;
                if (!blank($risk) && $enabled == 1) {
                    $change = $minUnit * $count;
                    $cache_data['price'] = PriceCalculate($cache_data['price'], '+', $change, 8);
                }

                // TODO 获取Kline数据 计算涨幅
                $kline_key = 'swap:' . $symbol . '_kline_1day';
                $last_cache_data = Cache::store('redis')->get($kline_key);
                if ($last_cache_data) {
                    $increase = $last_cache_data['open'] <= 0 ? 0 : PriceCalculate(($cache_data['price'] - $last_cache_data['open']), '/', $last_cache_data['open'], 4);
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
    }
    // 接受请求消息
    public static function recv_rep($data)
    {
        $ch = $data['rep'];
        $pattern_detail = '/^market\.(.*?)\.detail$/'; //市场概要
        if (preg_match($pattern_detail, $ch, $match_detail)) {
            $match = $match_detail[1];
            $symbol = str_before($match, '.');
            $symbol = str_before($symbol, '-');
            $after = str_after($match, '.');
            if ($after == 'trade') {
                $cache_data = $data['data'];
                $trade_list_key = 'swap:tradeList_' . $symbol;
                Cache::store('redis')->put($trade_list_key, $cache_data);
            }
        }
    }
}
