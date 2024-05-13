<?php

namespace App\Jobs\Timer\Spot;

use App\Jobs\Timer\Spot\Common;
use App\Models\OptionPair;
use App\SwooleWebsocket\WebsocketGroup;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AirCoin extends Common
{
    public function run()
    {
        $coins = config('coin.exchange_symbols');
        foreach ($coins as $coin => $class) {
            $coin = strtolower($coin);
            $symbol = $coin . 'usdt';

            // 深度买单列表
            $group_id = 'buyList_' . $symbol;
            $data = collect(self::getCoinBuyList($symbol, $class))->sortByDesc('price')->values()->toArray();
            $message = json_encode(['code' => 0, 'msg' => 'success', 'data' => $data, 'sub' => $group_id]);
            WebsocketGroup::sendToGroup($group_id, $message);

            // 深度卖单列表
            $group_id = 'sellList_' . $symbol;
            $data = self::getCoinSellList($symbol, $class);
            $message = json_encode(['code' => 0, 'msg' => 'success', 'data' => $data, 'sub' => $group_id]);
            WebsocketGroup::sendToGroup($group_id, $message);

            // 盘口数据
            $group_id = 'tradeList_' . $symbol;
            $data = self::getCoinTradeItem($symbol, $class);
            $message = json_encode(['code' => 0, 'msg' => 'success', 'type' => 'dynamic', 'data' => $data, 'sub' => $group_id]);
            WebsocketGroup::sendToGroup($group_id, $message);
            // K线数据
            $periods = ['1min', '5min', '15min', '30min', '60min', '1day', '1week', '1mon'];
            foreach ($periods as $period) {
                $data = self::getCoinKline($symbol, $period, $class);
                Cache::store('redis')->put('market:' . $symbol . '_kline_' . $period, $data);
                $group_id = 'Kline_' . $symbol . '_' . $period;
                $message = json_encode(['code' => 0, 'msg' => 'success', 'data' => $data, 'sub' => $group_id, 'type' => 'dynamic']);
                WebsocketGroup::sendToGroup($group_id, $message);
            }


            $kline = $class::query()->where('Date', '<', time())->where('is_1min', 1)->orderByDesc('Date')->first();
            $day_kline = $class::query()->where('Date', Carbon::yesterday()->getTimestamp())->where('is_day', 1)->orderByDesc('Date')->first();
            $now = Carbon::now();
            $data_24h = $class::query()
                ->whereBetween('Date', [Carbon::parse($now)->subDay()->getPreciseTimestamp(0), Carbon::parse($now)->getPreciseTimestamp(0)])
                ->where('is_1min', 1)
                ->select(DB::raw('max(High) as High,min(Low) as Low,sum(Volume) as Volume,sum(Amount) as Amount'))
                ->first()
                ->toArray();
            //获取下一分钟k线数据
            $data_nextmin = $class::query()
                ->whereBetween('Date', [Carbon::parse($now)->getPreciseTimestamp(0), Carbon::parse($now)->addSeconds(60)->getPreciseTimestamp(0)])
                ->where('is_1min', 1)
                ->first();
            $data_lastdaypremin = $class::query()
                ->whereBetween('Date', [Carbon::parse($now)->subDay()->getPreciseTimestamp(0), Carbon::parse($now)->subDay()->addSeconds(60)->getPreciseTimestamp(0)])
                ->where('is_1min', 1)
                ->first();
            $amount_next = ((($data_nextmin->Amount ?? 0) - ($data_lastdaypremin->Amount ?? 0)) / 60) * (time() % 60);
            $vol_next = ((($data_nextmin->Volume ?? 0) - ($data_lastdaypremin->Amount ?? 0)) / 60) * (time() % 60);
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
                    "low" => $data_24h['Low'],     //24小时最低价
                    "high" => $data_24h['High'],   //24小时最高价
                    "vol" => number_format($data_24h['Volume'] + $vol_next, 5, '.', ''),  //24小时交易量
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
                $cache_data['amount'] = number_format($data_24h['Amount'] + $amount_next, 5, '.', '');
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
                "ts" => $cache_data['ts'] ?? 0,
                "tradeId" => Str::uuid()->toString(),
                "amount" => $cache_data['amount'],
                "price" => $cache_data['price'],
                // "direction"=> "buy",
                'direction' => $symbol == strtolower(config('coin.coin_symbol')) ? 'buy' : mt_rand(0, 1) == 0 ? 'buy' : 'sell',
                "increase" => $cache_data['increase'],
                "increaseStr" => $cache_data['increaseStr']
            ];

            // 历史价格数据book
            $new_price_book_key = 'market:' . $symbol . '_newPriceBook';
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

            Cache::store('redis')->put('market:' . $symbol . '_detail', $cache_data);
            if (!blank($cache_data2)) {
                Cache::store('redis')->put('market:' . $symbol . '_newPrice', $cache_data2);

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
            // 获取期权最新价格
            $pairs = OptionPair::query()->where('status', 1)->get()->toArray();
            foreach ($pairs as $pair) {
                $group_id = 'newPrice_' . $pair['symbol'];
                $data = self::getNewPrice($pair['symbol']);
                $message = json_encode(['code' => 0, 'msg' => 'success', 'data' => $data, 'sub' => $group_id]);
                WebsocketGroup::sendToGroup($group_id, $message);
            }
        }
    }
}
