<?php


namespace App\Services;


use App\Exceptions\ApiException;
use App\Models\Coins;
use App\Models\OptionPair;
use App\Models\OptionScene;
use App\Models\OptionSceneOdds;
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
    public function sceneListByPairs()
    {
        $pairs = OptionPair::query()->where('status',1)->get();
        $times = OptionTime::query()->where('status',1)->get();

        $data = [];
        foreach ($pairs as $key => $pair){
            if(blank($pair)) continue;

            $cache_key = 'market:' . $pair['symbol'] . '_newPrice';
            $cache_data = Cache::store('redis')->get($cache_key);

            $pair_id = $pair['pair_id'];

            $data[$key]['guessPairsName'] = $pair['pair_name'];
            foreach ($times as $time){
                $time_id = $time['time_id'];
                $start = Carbon::now();
                $end = Carbon::now()->addSeconds($time['seconds']);
                $range = date_range($start,$end,$time['seconds']);
                $new_date = Arr::first($range,function ($value, $key) use ($start) {
                    return $value >= $start;
                });
                if($new_date){
                    $carbon_obj = Carbon::parse($new_date);
                    $begin_time = $carbon_obj->timestamp;
//                    $end_time = $carbon_obj->addSeconds($time['seconds'])->timestamp;
                    $where = [
                        'pair_id' => $pair_id,
                        'time_id' => $time_id,
                        'begin_time' => $begin_time,
                    ];
                    $scene = OptionScene::query()->where($where)->first();
                    $scene['increase'] = $cache_data['increase'];
                    $scene['increaseStr'] = $cache_data['increaseStr'];

                    $data[$key]['scenePairList'][] = $scene;
                }else{
                    $data[$key]['scenePairList'][] = [];
                }
            }
        }

        return $data;
    }

    public function sceneDetail($params)
    {
        $time = OptionTime::query()->findOrFail($params['time_id']);

        $start = Carbon::now();
        $end = Carbon::now()->addSeconds($time['seconds']);
        $range = date_range($start,$end,$time['seconds']);
        $current_date = Arr::last($range,function ($value, $key) use ($start) {
            return $value <= $start;
        });
        $next_date = Arr::first($range,function ($value, $key) use ($start) {
            return $value >= $start;
        });

//        dd($current_date,$next_date);
        if($next_date){
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
            return ['current_scene'=>$current_scene,'next_scene'=>$next_scene];
        }else{
            return [];
        }
    }

    public function getOddsList($params)
    {
        $time = OptionTime::query()->findOrFail($params['time_id']);

        $start = Carbon::now();
        $end = Carbon::now()->addSeconds($time['seconds']);
        $range = date_range($start,$end,$time['seconds']);
        $next_date = Arr::first($range,function ($value, $key) use ($start) {
            return $value >= $start;
        });

        if($next_date){
            $begin_time = Carbon::parse($next_date)->timestamp;
            $where = [
                'pair_id' => $params['pair_id'],
                'time_id' => $params['time_id'],
                'begin_time' => $begin_time,
            ];
            return OptionScene::query()->where($where)->first();
        }else{
            return [];
        }
    }

    public function getSceneResultList($params)
    {
        return OptionScene::query()
            ->where('status',OptionScene::status_delivered)
            ->where('pair_id',$params['pair_id'])
            ->where('time_id',$params['time_id'])
            ->latest()
            ->paginate();
    }

    public function getOptionHistoryOrders($user,$params)
    {
        $builder = OptionSceneOrder::query()->where('user_id',$user['user_id'])->with('scene');
        if(isset($params['status'])){
            $builder->where('status',$params['status']);
        }
        if(isset($params['pair_id']) && isset($params['time_id'])){
            $builder->where('pair_id',$params['pair_id'])->where('time_id',$params['time_id']);
        }
        return $builder->latest()->paginate();
    }

    public function betScene($user,$params)
    {
        DB::beginTransaction();
        try{
            $uuid = $params['odds_uuid'];
            $scene = OptionScene::query()->findOrFail($params['scene_id']);
            $odds_arr = array_collapse([$scene['up_odds'],$scene['down_odds'],$scene['draw_odds']]);
            $odds = array_first($odds_arr, function ($value, $key) use ($uuid) {
                return $value['uuid'] == $uuid;
            });
            if(blank($odds)) throw new ApiException('参数错误');

            $coin = Coins::query()->findOrFail($params['bet_coin_id']);

            if( ($res = $scene->can_bet()) !== true ){
                throw new ApiException($res);
            }

            //创建订单
            $order_data = [
                'user_id' => $user['user_id'],
                'order_no' => get_order_sn('OP'),
                'scene_id' => $params['scene_id'],
                'pair_id' => $scene['pair_id'],
                'pair_name' => str_before($scene['pair_time_name'],'-'),
                'time_name' => str_after($scene['pair_time_name'],'-'),
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
            $user->update_wallet_and_log($coin['coin_id'],'usable_balance',-$params['bet_amount'],UserWallet::asset_account,'bet_option');

            DB::commit();

            return $scene_order;
        }catch (\Exception $e){
            DB::rollBack();
            throw new ApiException($e->getMessage());
        }
    }

}
