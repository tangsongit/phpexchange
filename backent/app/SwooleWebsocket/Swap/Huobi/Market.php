<?php

namespace App\SwooleWebsocket\Swap\Huobi;

use App\Models\InsideTradePair;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Swoole\Coroutine\Http\Client;
use Swoole\Coroutine;
use function Swoole\Coroutine\run;
use Illuminate\Support\Arr;
use Hhxsv5\LaravelS\Swoole\Process\CustomProcessInterface;
use Illuminate\Support\Facades\Redis;
use Swoole\Http\Server;
use Swoole\Process;

class Market extends Huobi implements CustomProcessInterface
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
                $msg = ["sub" => "market." . $symbol . ".detail", "id" => rand(100000, 999999) . time()];
                self::$client->push(json_encode($msg));
            });
    }
    // 接受订阅消息
    public static function recv_ch($data)
    {
        $ch = $data['ch'];
        $pattern_detail = '/^market\.(.*?)\.detail$/'; //正则匹配市场概要
        if (preg_match($pattern_detail, $ch, $match_detail)) {
            $match = $match_detail[1];
            $symbol = str_before($match, '.');
            $symbol = str_before($symbol, '-');
            $after = str_after($match, '.');
            if ($after != 'trade') {
                // 市场概况
                $cache_data = $data['tick'];

                $risk_key = 'fkJson:' . $symbol . '/USDT';
                $risk = json_decode(Redis::get($risk_key), true);
                $minUnit = $risk['minUnit'] ?? 0;
                $count = $risk['count'] ?? 0;
                $enabled = $risk['enabled'] ?? 0;
                if (!blank($risk) && $enabled == 1) {
                    $change = $minUnit * $count;
                    $cache_data['close'] = PriceCalculate($cache_data['close'], '+', $change, 8);
                    $cache_data['open'] = PriceCalculate($cache_data['open'], '+', $change, 8);
                    $cache_data['high'] = PriceCalculate($cache_data['high'], '+', $change, 8);
                    $cache_data['low'] = PriceCalculate($cache_data['low'], '+', $change, 8);
                }

                if (isset($cache_data['open']) && $cache_data['open'] != 0) {
                    // 获取1dayK线 计算$increase
                    $day_kline = Cache::store('redis')->get('swap:' . $symbol . '_kline_' . '1day');
                    if (blank($day_kline)) {
                        $increase = PriceCalculate(($cache_data['close'] - $cache_data['open']), '/', $cache_data['open'], 4);
                    } else {
                        $increase = PriceCalculate(($cache_data['close'] - $day_kline['open']), '/', $day_kline['open'], 4);
                    }
                } else {
                    $increase = 0;
                }
                $cache_data['increase'] = $increase;
                $flag = $increase >= 0 ? '+' : '';
                $cache_data['increaseStr'] = $increase == 0 ? '+0.00%' : $flag . $increase * 100 . '%';

                $key = 'swap:' . $symbol . '_detail';
                Cache::store('redis')->put($key, $cache_data);
            }
        }
    }
    // 接受请求消息
    public static function recv_rep($data)
    {
    }
}
