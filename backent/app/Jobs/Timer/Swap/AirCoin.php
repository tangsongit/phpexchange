<?php

namespace App\Jobs\Timer\Swap;

use App\Jobs\Timer\Swap\Common;
use App\SwooleWebsocket\WebsocketGroup;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AirCoin extends Common
{
    public function run()
    {
        // COIN_SYMBOL -- START
        $coins = config('coin.swap_symbols');
        foreach ($coins as $coin => $class) {
            $symbol = $coin;
            $group_id = 'swapBuyList_' . $symbol;
            $data = self::getCoinBuyList($symbol, $class);
            $message = json_encode(['code' => 0, 'msg' => 'success', 'data' => $data, 'sub' => $group_id]);
            WebsocketGroup::sendToGroup($group_id, $message);

            $group_id = 'swapSellList_' . $symbol;
            $data = self::getCoinBuyList($symbol, $class);
            $message = json_encode(['code' => 0, 'msg' => 'success', 'data' => $data, 'sub' => $group_id]);
            WebsocketGroup::sendToGroup($group_id, $message);


            $group_id = 'swapTradeList_' . $symbol;
            $data = self::getCoinTradeItem($symbol, $class);
            $message = json_encode(['code' => 0, 'msg' => 'success', 'type' => 'dynamic', 'data' => $data, 'sub' => $group_id]);


            $periods = ['1min', '5min', '15min', '30min', '60min', '1day', '1week', '1mon'];
            foreach ($periods as $period) {
                $data = self::getCoinKline($symbol, $period, $class);
                Cache::store('redis')->put('swap:' . $symbol . '_kline_' . $period, $data);
                $group_id = 'swapKline_' . $symbol . '_' . $period;
                $message = json_encode(['code' => 0, 'msg' => 'success', 'data' => $data, 'sub' => $group_id, 'type' => 'dynamic']);
                WebsocketGroup::sendToGroup($group_id, $message);
            }

            $coin1_symbol = $coin;
            $kline = $class::query()->where('Date', '<', time())->where('is_1min', 1)->orderByDesc('Date')->first();
            $day_kline = $class::query()->where('Date', Carbon::yesterday()->getTimestamp())->where('is_day', 1)->orderByDesc('Date')->first();
            if (blank($kline)) {
                $cache_data = [];
                return;
            } else {
                $decimal = 100000;
                $ups_downs_high = 20;            //高
                $ups_downs_low = 1;              //低
                $up_or_down = mt_rand(1, 5);
                $flag2 = mt_rand(1, 2);
                $cache_data = [
                    "id" => $kline['Date'],
                    "count" => $day_kline['Amount'],
                    "open" => $kline['Open'],
                    "low" => $kline['Low'],
                    "high" => $kline['High'],
                    "vol" => $day_kline['Volume'],
                    "version" => $kline['Date'],
                    'ts' => \Carbon\Carbon::now()->getPreciseTimestamp(3),
                ];
                $cache_data['amount'] = $flag2 == 1 ? round($day_kline['Amount'] + (mt_rand(10, 40) / 100000), 5) : round($day_kline['Amount'] - (mt_rand(10, 40) / 100000), 5);
                $decimal_price = $kline['Close'] * $decimal;
                if ($up_or_down <= 3) {
                    $cache_data['close'] = mt_rand($decimal_price, $decimal_price + mt_rand($ups_downs_low, $ups_downs_high)) / $decimal;
                } else {
                    $cache_data['close'] = mt_rand($decimal_price - mt_rand($ups_downs_low, $ups_downs_high), $decimal_price) / $decimal;
                }
                $cache_data['price'] = $cache_data['close'];
                if (isset($cache_data['open']) && $cache_data['open'] != 0) {
                    if (blank($day_kline)) {
                        if (($cache_data['close'] - $cache_data['open']) == 0) {
                            $increase = 0;
                        } else {
                            $increase = round(($cache_data['close'] - $cache_data['open']) / $cache_data['open'], 4);
                        }
                    } else {
                        if (($cache_data['close'] - $day_kline['Close']) == 0) {
                            $increase = 0;
                        } else {
                            $increase = round(($cache_data['close'] - $day_kline['Close']) / $day_kline['Close'], 4);
                        }
                    }
                } else {
                    $increase = 0;
                }
                $cache_data['increase'] = $increase;
                $flag = $increase >= 0 ? '+' : '';
                $cache_data['increaseStr'] = $increase == 0 ? '+0.00%' : $flag . $increase * 100 . '%';
            }
            $cache_data2 = [
                "id" => Str::uuid()->toString(),
                "ts" => $cache_data['ts'],
                "tradeId" => Str::uuid()->toString(),
                "amount" => $cache_data['amount'],
                "price" => $cache_data['price'],
                // "direction"=> "buy",
                'direction' => mt_rand(0, 1) == 0 ? 'buy' : 'sell',
                "increase" => $cache_data['increase'],
                "increaseStr" => $cache_data['increaseStr']
            ];

            // 历史价格数据book
            //                    $new_price_book_key = 'swap:' . $coin1_symbol . '_newPriceBook';
            $new_price_book_key = 'swap:tradeList_' . $coin1_symbol;
            $new_price_book = Cache::store('redis')->get($new_price_book_key);
            if (blank($new_price_book)) {
                $prices = [];
            } else {
                $size = count($new_price_book) >= 10 ? 10 : count($new_price_book);
                $prices = array_random($new_price_book, $size);
                $prices = array_values(Arr::sort($prices, function ($value) {
                    return $value['ts'];
                }));
                $prices = Arr::pluck($prices, 'price');
            }
            $cache_data['prices'] = $prices;

            Cache::store('redis')->put('swap:' . $coin1_symbol . '_detail', $cache_data);
            if (!blank($cache_data2)) {
                Cache::store('redis')->put('swap:trade_detail_' . $coin1_symbol, $cache_data);
                //缓存历史价格数据book
                if (blank($new_price_book)) {
                    Cache::store('redis')->put($new_price_book_key, [$cache_data2]);
                } else {
                    array_push($new_price_book, $cache_data2);
                    if (count($new_price_book) > 200) {
                        array_shift($new_price_book);
                    }
                    Cache::store('redis')->put($new_price_book_key, $new_price_book);
                }
            }
        }
    }
}
