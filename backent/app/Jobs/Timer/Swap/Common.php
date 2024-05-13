<?php

namespace App\Jobs\Timer\Swap;

use App\Models\Coins;
use App\Models\InsideTradePair;
use App\SwooleWebsocket\WebsocketGroup;
use Carbon\Carbon;
use Hhxsv5\LaravelS\Swoole\Timer\CronJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Common extends CronJob
{
    protected $i = 0;

    public function interval()
    {
        return 1000;
    }
    public function isImmediate()
    {
        return true;
    }
    public function run()
    {
    }

    public static function getMarketList($type = 'marketList')
    {
        $marketList = [];
        $symbols = \App\Models\ContractPair::query()->where('status', 1)->pluck('symbol');
        $kk = 0;
        foreach ($symbols as $k => $symbol) {
            $coin = array_first(Coins::getCachedCoins(), function ($value, $key) {
                return $value['coin_name'] == 'USDT';
            });
            $marketList[$kk]['coin_name'] = $coin['coin_name'];
            $marketList[$kk]['full_name'] = $coin['full_name'];
            $marketList[$kk]['coin_icon'] = getFullPath($coin['coin_icon']);
            $marketList[$kk]['coin_content'] = $coin['coin_content'];
            $marketList[$kk]['qty_decimals'] = $coin['qty_decimals'];
            $marketList[$kk]['price_decimals'] = $coin['price_decimals'];
            $cd = Cache::store('redis')->get('swap:' . $symbol . '_detail');
            $data = $cd;
            $data['price'] = $cd['close'];
            $data['symbol'] = $symbol;
            $data['pair_name'] = $symbol . '/' . 'USDT';
            $data['type'] = 'USDT';
            // 合约列表中增加日线（压缩） （只显示6条数据）
            try {
                $kline = Cache::store('redis')->get('swap:' . $symbol . '_kline_book_1day');
                $data_count = count($kline ?? []);
                $step = bcdiv($data_count, 6, 8);
                $new_data = [];
                for ($i = 0; ($i * $step) < $data_count; $i++) {
                    $new_data[] = $kline[intval($i * $step)]['close'] ?? 0;
                }
                $kline_base = bcdiv(max($new_data), 100, 8);
                $kline = [];
                if (!blank($kline_base) && $kline_base != 0) {
                    for ($i = 0; $i < 6; $i++) {
                        $kline[] = bcdiv($new_data[$i], $kline_base, 0);
                    }
                }
                $data['series'][] = [
                    'data' => $kline,
                    'color' => ($cd['increase'] < 0) ? '#ea3131' : '#60c08c',
                ];
            } catch (\Exception $e) {
                info($e);
                $data['series'][]['data'] = [];
            }


            $marketList[$kk]['marketInfoList'][$k] = $data;
        }
        return $marketList;
    }

    public static function getTickerList()
    {
        $ticker = [];
        $symbols = \App\Models\ContractPair::query()->where('status', 1)->pluck('symbol');
        $kk = 0;
        foreach ($symbols as $symbol) { //根据
            $coin = array_first(Coins::getCachedCoins(), function ($value, $key) {
                return $value['coin_name'] == 'USDT';
            });
            if (blank($coin)) return; //如果不存在交易货币则返回空值
            $cd = Cache::store('redis')->get('swap:' . $symbol . '_detail'); //从redis中获取ticker数据
            $cd['symbol'] = $symbol;
            $cd['anchor'] = 'USDT';
            $ticker[$kk] = $cd;
            $kk++;
        }
        return $ticker;
    }

    public static function getCoinKline($symbol, $period, $class)
    {
        $periods = [
            '1min' => 60,
            '5min' => 300,
            '15min' => 900,
            '30min' => 1800,
            '60min' => 3600,
            '1day' => 86400,
            '1week' => 604800,
            '1mon' => 2592000,
        ];
        $wheres = [
            '1min' => 'is_1min',
            '5min' => 'is_5min',
            '15min' => 'is_15min',
            '30min' => 'is_30min',
            '60min' => 'is_1h',
            '1day' => 'is_day',
            '1week' => 'is_week',
            '1mon' => 'is_month',
        ];
        $seconds = $periods[$period] ?? 60;
        $where = $wheres[$period] ?? 'is_1min';
        $kline = $class::query()->where($where, 1)->where('Date', '>', (time() - $seconds))->where('Date', '<=', time())->first();
        $kline_cache_data = Cache::store('redis')->get('swap:' . $symbol . '_detail');
        if ($kline['Date'] == time()) {
            $cache_data = [
                "id" => $kline['Date'],
                "amount" => $kline['Amount'],
                "count" => mt_rand(10, 55),
                "open" => $kline['Open'],
                "close" => $kline['Close'],
                "low" => $kline['Low'],
                "high" => $kline['High'],
                "vol" => $kline['Volume']
            ];
            $cache_data['price'] = $cache_data['close'];
        } else {
            $cache_data = [
                "id" => $kline['Date'],
                "amount" => round($kline['Amount'] + (mt_rand(10, 99) / 10000), 5),
                "count" => mt_rand(10, 55),
                "open" => $kline['Open'],
                "close" => $kline_cache_data['close'],
                "low" => $kline['Low'],
                "high" => $kline['High'],
                "vol" => $kline['Volume']
            ];
            $cache_data['price'] = $cache_data['close'];
        }

        return $cache_data;
    }

    public static function getCoinBuyList($symbol, $class)
    {
        $kline = $class::query()->where('is_1min', 1)->where('Date', '<', time())->orderByDesc('Date')->first();
        if (blank($kline)) return [];
        $kline_cache_data = Cache::store('redis')->get('swap:' . $symbol . '_detail');
        $buyList = [];

        for ($i = 0; $i <= 19; $i++) {
            if ($i == 0) {
                $buyList[$i] = [
                    'id' => Str::uuid(),
                    "amount" => round((mt_rand(10000, 3000000) / 1000), 4),
                    'price' => $kline_cache_data['close'],
                ];
            } else {
                $open = $kline['Open'];
                $close = $kline['Close'];
                $min = min($open, $close) * 100000;
                $max = max($open, $close) * 100000;
                $price = round(mt_rand($min, $max) / 100000, 5);

                $buyList[$i] = [
                    'id' => Str::uuid()->toString(),
                    "amount" => round((mt_rand(10000, 3000000) / 1000), 4),
                    'price' => $price,
                ];
            }
        }
        return $buyList;
    }

    public static function getCoinTradeList($symbol, $class)
    {
        $kline = $class::query()->where('is_1min', 1)->where('Date', '<', time())->orderByDesc('Date')->first();
        if (blank($kline)) return [];
        $kline_cache_data = Cache::store('redis')->get('swap:' . $symbol . '_detail');
        $tradeList = [];

        for ($i = 0; $i <= 30; $i++) {
            if ($i == 0) {
                $tradeList[$i] = [
                    'id' => Str::uuid(),
                    "amount" => round((mt_rand(10000, 3000000) / 1000), 4),
                    'price' => $kline_cache_data['close'],
                    'tradeId' => Str::uuid()->toString(),
                    'ts' => Carbon::now()->getPreciseTimestamp(3),
                    'increase' => -0.1626,
                    'increaseStr' => "-16.26%",
                    'direction' => mt_rand(0, 1) == 0 ? 'buy' : 'sell',
                ];
            } else {
                $open = $kline['Open'];
                $close = $kline['Close'];
                $min = min($open, $close) * 100000;
                $max = max($open, $close) * 100000;
                $price = round(mt_rand($min, $max) / 100000, 5);

                $tradeList[$i] = [
                    'id' => Str::uuid()->toString(),
                    "amount" => round((mt_rand(10000, 3000000) / 1000), 4),
                    'price' => $price,
                    'tradeId' => Str::uuid()->toString(),
                    'ts' => Carbon::now()->getPreciseTimestamp(3),
                    'increase' => -0.1626,
                    'increaseStr' => "-16.26%",
                    'direction' => mt_rand(0, 1) == 0 ? 'buy' : 'sell',
                ];
            }
        }
        return $tradeList;
    }

    public static function getNewPrice($symbol)
    {
        $key = 'swap:' . $symbol . '_newPrice';
        $data = Cache::store('redis')->get($key);
        $data['ts'] = Carbon::now()->getPreciseTimestamp(3);
        return $data;
    }

    public static function getCoinTradeItem($symbol, $class = null)
    {
        $kline_cache_data = Cache::store('redis')->get('swap:' . $symbol . '_detail');
        $tradeItem = [
            'id' => Str::uuid()->toString(),
            "amount" => round((mt_rand(10000, 3000000) / 1000), 4),
            'price' => $kline_cache_data['close'],
            'tradeId' => Str::uuid()->toString(),
            'ts' => Carbon::now()->getPreciseTimestamp(3),
            'increase' => 0,
            'increaseStr' => "--",
            'direction' => mt_rand(0, 1) == 0 ? 'buy' : 'sell',
        ];

        return $tradeItem;
    }
}
