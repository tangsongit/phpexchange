<?php

namespace App\SwooleWebsocket\Spot\Binance;

use App\Models\InsideTradePair;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Swoole\Coroutine\Http\Client;
use Swoole\Coroutine;
use function Swoole\Coroutine\run;
use Illuminate\Support\Arr;
use Hhxsv5\LaravelS\Swoole\Process\CustomProcessInterface;
use Swoole\Http\Server;
use Swoole\Process;

class Market extends Binance
{
    protected static $client;

    // 用于向服务器发送数据
    public static function push()
    {
        self::subscribe(InsideTradePair::query()
            ->where(['status' => 1, 'is_market' => 1])
            ->pluck('symbol')
            ->map(function ($symbol) {
                return "{$symbol}@ticker";
            })->toArray());
    }
    // 接受订阅消息
    public static function recv_ch($data)
    {
        $stream = $data['stream'];
        $symbol = str_before($stream, '@'); //币种名称

        // k线原始数据
        $resdata = $data['data'];

        // 市场概况
        $cache_data = [
            'id' => $resdata['E'], //unix时间戳 13位
            'low' => $resdata['l'], //24小时最低价
            'high' => $resdata['h'], //24小时最高价
            'open' => $resdata['o'], //24小时开盘价
            'close' => $resdata['c'],    //最新价格
            'vol' => $resdata['q'],  //24小时成交额
            'amount' => $resdata['v'], //24小时成交量
        ];

        if (isset($cache_data['open']) && round($cache_data['open'], 8) != 0) {
            // 获取1dayK线 计算$increase
            $day_kline = Cache::store('redis')->get('market:' . $symbol . '_kline_' . '1day');
            if (!blank($day_kline) && round($day_kline['open'], 8) != 0) {
                $increase = round(bcMath(($cache_data['close'] - $day_kline['open']), $day_kline['open'], '/', 8), 4);
            } else {
                $increase = round(bcMath(($cache_data['close'] - $cache_data['open']), $cache_data['open'], '/', 8), 4);
            }
        } else {
            $increase = 0;
        };
        $cache_data['increase'] = $increase;
        $flag = $increase >= 0 ? '+' : '';
        $cache_data['increaseStr'] = $increase == 0 ? '+0.00%' : $flag . $increase * 100 . '%';

        // 取价格波动折线数据
        $tmp = Cache::store('redis')->get('market:' . $symbol . '_newPriceBook');
        if (blank($tmp)) {
            $prices = [];
        } else {
            $size = count($tmp) >= 10 ? 10 : count($tmp);
            $prices_step1 = array_random($tmp, $size);
            $prices_step2 = array_values(Arr::sort($prices_step1, function ($value) {
                return $value['ts'];
            }));
            $prices = Arr::pluck($prices_step2, 'price');
        }
        $cache_data['prices'] = $prices;

        $key = 'market:' . $symbol . '_detail';
        Cache::store('redis')->put($key, $cache_data);
    }
    // 接受请求消息
    public static function recv_rep($data)
    {
    }
}
