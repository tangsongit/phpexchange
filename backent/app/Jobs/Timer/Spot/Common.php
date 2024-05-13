<?php

namespace App\Jobs\Timer\Spot;

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
        return 500;
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
        $market = [];
        $data = InsideTradePair::getCachedPairs();
        $kk = 0;
        foreach ($data as $k => $items) {
            $coin = array_first(Coins::getCachedCoins(), function ($value, $key) use ($k) {
                return $value['coin_name'] == $k;
            });
            if (blank($coin)) continue;
            $market[$kk]['coin_name'] = $coin['coin_name'];
            $market[$kk]['full_name'] = $coin['full_name'];
            $market[$kk]['coin_icon'] = getFullPath($coin['coin_icon']);
            $market[$kk]['coin_content'] = $coin['coin_content'];
            $market[$kk]['qty_decimals'] = $coin['qty_decimals'];
            $market[$kk]['price_decimals'] = $coin['price_decimals'];
            foreach ($items as $key2 => $item) {
                $cd = Cache::store('redis')->get('market:' . $item['symbol'] . '_detail');
                $coin_name = $item['base_coin_name'];
                $coin2 = array_first(Coins::getCachedCoins(), function ($value, $key) use ($coin_name) {
                    return $value['coin_name'] == $coin_name;
                });
                $cd['price'] = $cd['close'];
                $cd['qty_decimals'] = $item['qty_decimals'];    //交易量精度
                $cd['price_decimals'] = $item['price_decimals'];    //价格精度
                $cd['min_qty'] = $item['min_qty'];
                $cd['min_total'] = $item['min_total'];
                $cd['coin_name'] = $item['base_coin_name'];
                $cd['coin_icon'] = getFullPath($coin2['coin_icon']);
                $cd['pair_id'] = $item['pair_id'];
                $cd['pair_name'] = $item['pair_name'];
                $cd['symbol'] = $item['symbol'];

                // 现货列表中增加日线（压缩） （只显示6条数据）
                try {
                    $kline = Cache::store('redis')->get('market:' . $item['symbol'] . '_kline_book_1day');
                    $data_count = count($kline ?? []);
                    $step = bcdiv($data_count, 6, 8);
                    $new_data = [];
                    for ($i = 0; ($i * $step) < $data_count; $i++) {
                        $new_data[] = $kline[(intval($i * $step))]['close'] ?? null;
                    }
                    $kline_base = bcdiv(max($new_data), 100, 8);
                    $kline = [];
                    if (!blank($kline_base) && $kline_base != 0) {
                        for ($i = 0; $i < 6; $i++) {
                            $kline[] = bcdiv($new_data[$i], $kline_base, 0);
                        }
                    }
                    $cd['series'][] = [
                        'data' => $kline,
                        'color' => ($cd['increase'] < 0) ? '#ea3131' : '#60c08c',
                    ];
                } catch (\Exception $e) {
                    info($e);
                    $cd['series'][]['data'] = [];
                }
                $market[$kk]['marketInfoList'][$key2] = $cd;
            }
            $kk++;
        }
        return $market;
    }

    public static function getTickerList()
    {
        $ticker = [];
        $data = InsideTradePair::getCachedPairs1();
        $kk = 0;
        foreach ($data as $item) {
            $coin = array_first(Coins::getCachedCoins(), function ($value, $key) use ($item) {
                return $value['coin_name'] == $item['quote_coin_name'];
            });
            if (blank($coin)) return; //如果不存在交易货币则返回空值
            $cd = Cache::store('redis')->get('market:' . $item['symbol'] . '_detail'); //从redis中获取ticker数据
            $cd['base_coin_name'] =  $item['base_coin_name'];
            $cd['quote_coin_name'] =  $item['quote_coin_name'];
            $ticker[$kk] = $cd;
            $kk++;
        }
        return $ticker;
    }

    public static function onWebSocketConnect($client_id, $data)
    {
        echo "onWebSocketConnect\r\n";
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
        $kline_cache_data = Cache::store('redis')->get('market:' . $symbol . '_detail');
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
        $kline_cache_data = Cache::store('redis')->get('market:' . $symbol . '_detail');
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
                $high = $kline['High'];
                $low = $kline['Low'];
                $min = min($open, $close, $low, $kline_cache_data['close']) * 100000;
                $max = $kline_cache_data['close'] * 100000;
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
    public static function getCoinSellList($symbol, $class)
    {
        $kline = $class::query()->where('is_1min', 1)->where('Date', '<', time())->orderByDesc('Date')->first();
        if (blank($kline)) return [];
        $kline_cache_data = Cache::store('redis')->get('market:' . $symbol . '_detail');
        $buyList = [];

        for ($i = 0; $i <= 19; $i++) {
            if ($i == 0) {
                $buyList[$i] = [
                    'id' => Str::uuid(),
                    "amount" => round((mt_rand(10000, 3000000) / 1000), 4),
                    'price' => $kline_cache_data['close'], //第一条数据为最新价
                ];
            } else {
                $open = $kline['Open'];
                $close = $kline['Close'];
                $high = $kline['High'];
                $low = $kline['Low'];
                $min = $kline_cache_data['close'] * 100000;
                $max = max($high, $close, $open, $kline_cache_data['close']) * 100000;
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
        $kline_cache_data = Cache::store('redis')->get('market:' . $symbol . '_detail');
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
        $key = 'market:' . $symbol . '_newPrice';
        $data = Cache::store('redis')->get($key);
        $data['ts'] = Carbon::now()->getPreciseTimestamp(3);
        return $data;
    }

    public static function getCoinTradeItem($symbol, $class = null)
    {
        $kline_cache_data = Cache::store('redis')->get('market:' . $symbol . '_detail');
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
