<?php


namespace App\Services;


use App\Exceptions\ApiException;
use App\Models\Coins;
use App\Models\OptionPair;
use App\Models\OptionScene;
use App\Models\OptionSceneOrder;
use App\Models\OptionTime;
use App\Models\User;
use App\Models\UserWallet;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SceneService
{
    public function sceneListByTimes()
    {
        $pairs = OptionPair::query()->where('status', 1)->select(['pair_id', 'pair_name', 'symbol'])->get()->toArray();
        $times = OptionTime::query()->where('status', 1)->select(['time_id', 'time_name', 'seconds'])->get()->toArray();

        $data = [];
        foreach ($times as $key => $time) {
            $time_id = $time['time_id'];
            $data[$key]['guessTimeName'] = $time['time_name'];

            foreach ($pairs as $key2 => $pair) {
                $cache_data = Cache::store('redis')->get('market:' . $pair['symbol'] . '_newPrice');
                $pair_id = $pair['pair_id'];
                $scene = OptionScene::query()->where([
                    ['time_id', '=', $time_id],
                    ['pair_id', '=', $pair_id],
                    ['end_time', '>=', time()],
                    //                    ['begin_time','>=',time()],
                    ['end_time', '<', time() + $time['seconds']],
                ])->first();
                if (!blank($scene)) {
                    $scene['upodds'] = $scene['up_odds'][0]['odds'];
                    $scene['downodds'] = $scene['down_odds'][0]['odds'];
                }
                $scene['increase'] = $cache_data['increase'];
                $scene['increaseStr'] = $cache_data['increaseStr'];
                if ($key2 == 0) {
                    $scene['trend_up'] = rand(10, 99) / 100;
                    $scene['trend_down'] = 1 - $scene['trend_up'];
                    // 取价格波动折线数据
                    $prices = array_random(Cache::store('redis')->get('market:' . $pair['symbol'] . '_newPriceBook'), 10);
                    $prices = array_values(Arr::sort($prices, function ($value) {
                        return $value['ts'];
                    }));
                    $prices = Arr::pluck($prices, 'price');
                    $scene['prices'] = $prices;
                }
                $data[$key]['scenePairList'][] = $scene;
            }
        }
        return $data;
    }

    public function sceneListByPairs()
    {
        $pairs = OptionPair::query()->where('status', 1)->select(['pair_id', 'pair_name', 'symbol'])->get()->toArray();
        $times = OptionTime::query()->where('status', 1)->select(['time_id', 'time_name', 'seconds'])->get()->toArray();

        $data = [];
        foreach ($pairs as $key => $pair) {
            $cache_data = Cache::store('redis')->get('market:' . $pair['symbol'] . '_newPrice');
            $pair_id = $pair['pair_id'];

            $data[$key]['guessPairsName'] = $pair['pair_name'];
            foreach ($times as $time) {
                $time_id = $time['time_id'];
                $scene = OptionScene::query()->where([
                    ['time_id', '=', $time_id],
                    ['pair_id', '=', $pair_id],
                    ['end_time', '>=', time()],
                    ['end_time', '<', time() + $time['seconds']],
                ])->first();
                $scene['increase'] = $cache_data['increase'];
                $scene['increaseStr'] = $cache_data['increaseStr'];

                $data[$key]['scenePairList'][] = $scene;
            }
        }

        return $data;
    }

    public function sceneDetail($params)
    {
        $time = OptionTime::query()->findOrFail($params['time_id']);

        $start = Carbon::now();
        $end = Carbon::now()->addSeconds($time['seconds']);
        $range = date_range($start, $end, $time['seconds']);
        $current_date = Arr::last($range, function ($value, $key) use ($start) {
            return $value <= $start;
        });
        $next_date = Arr::first($range, function ($value, $key) use ($start) {
            return $value >= $start;
        });

        //        dd($current_date,$next_date);
        if ($next_date) {
            $begin_time1 = Carbon::parse($current_date)->timestamp;
            $begin_time2 = Carbon::parse($next_date)->timestamp;
            $where1 = [
                'pair_id' => $params['pair_id'],
                'time_id' => $params['time_id'],
                'begin_time' => $begin_time1,
            ];
            $where2 = [
                'pair_id' => $params['pair_id'],
                'time_id' => $params['time_id'],
                'begin_time' => $begin_time2,
            ];
            $current_scene = OptionScene::query()->where($where1)->first();
            $next_scene = OptionScene::query()->where($where2)->first();
            return ['current_scene' => $current_scene, 'next_scene' => $next_scene];
        } else {
            return [];
        }
    }

    public function getOddsList($params)
    {
        $time = OptionTime::query()->findOrFail($params['time_id']);

        $start = Carbon::now();
        $end = Carbon::now()->addSeconds($time['seconds']);
        $range = date_range($start, $end, $time['seconds']);
        $next_date = Arr::first($range, function ($value, $key) use ($start) {
            return $value >= $start;
        });

        if ($next_date) {
            $begin_time = Carbon::parse($next_date)->timestamp;
            $where = [
                'pair_id' => $params['pair_id'],
                'time_id' => $params['time_id'],
                'begin_time' => $begin_time,
            ];
            return OptionScene::query()->where($where)->first();
        } else {
            return [];
        }
    }

    public function getSceneResultList($params)
    {
        $data = OptionScene::query()
            ->where('status', OptionScene::status_delivered)
            ->where('pair_id', $params['pair_id'])
            ->where('time_id', $params['time_id'])
            ->latest()
            ->paginate()
            ->toArray();
        // 输出交割数据保留三位小数
        $data['data'] = collect($data['data'])->map(function ($v) {
            $v['delivery_range'] = number_format($v['delivery_range'], 3, '.', '');
            return $v;
        });
        return $data;
    }

    public function getOptionHistoryOrders($user, $params)
    {
        $builder = OptionSceneOrder::query()->where('user_id', $user['user_id'])->with('scene');
        if (isset($params['status'])) {
            $builder->where('status', $params['status']);
        }
        if (isset($params['pair_id']) && isset($params['time_id'])) {
            $builder->where('pair_id', $params['pair_id'])->where('time_id', $params['time_id']);
        }
        return $builder->latest()->paginate();
    }

    public function getOptionOrderDetail($user, $params)
    {
        return OptionSceneOrder::with('scene')->where('user_id', $user['user_id'])->where('order_id', $params['order_id'])->first();
    }

    public function betScene($user, $params)
    {
        DB::beginTransaction();
        try {
            $uuid = $params['odds_uuid'];
            $scene = OptionScene::query()->findOrFail($params['scene_id']);
            $odds_arr = array_collapse([$scene['up_odds'], $scene['down_odds'], $scene['draw_odds']]);
            $odds = array_first($odds_arr, function ($value, $key) use ($uuid) {
                return $value['uuid'] == $uuid;
            });
            if (blank($odds)) throw new ApiException('参数错误');

            $coin = Coins::query()->findOrFail($params['bet_coin_id']);

            if (($res = $scene->can_bet()) !== true) {
                throw new ApiException($res);
            }

            //创建订单
            $order_data = [
                'user_id' => $user['user_id'],
                'order_no' => get_order_sn('OP'),
                'scene_id' => $params['scene_id'],
                'pair_id' => $scene['pair_id'],
                'pair_name' => str_before($scene['pair_time_name'], '-'),
                'time_name' => str_after($scene['pair_time_name'], '-'),
                'time_id' => $scene['time_id'],
                'bet_amount' => $params['bet_amount'],
                'bet_coin_id' => $params['bet_coin_id'],
                'bet_coin_name' => $coin['coin_name'],
                'odds_uuid' => $params['odds_uuid'],
                'odds' => $odds['odds'],
                'range' => $odds['range'],
                'up_down' => $odds['up_down'],
                'begin_time' => $scene['begin_time'],
                'end_time' => $scene['end_time'],
            ];
            $scene_order = OptionSceneOrder::query()->create($order_data);

            //扣除用户资产
            $user->update_wallet_and_log($coin['coin_id'], 'usable_balance', -$params['bet_amount'], UserWallet::asset_account, 'bet_option', '', '', $scene_order->order_id, OptionSceneOrder::class);

            DB::commit();

            return $scene_order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiException($e->getMessage());
        }
    }
}
