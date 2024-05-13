<?php

namespace App\Console\Commands;

use App\Models\OptionPair;
use App\Models\OptionScene;
use App\Models\OptionTime;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateOptionScene extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createOptionScene';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建期权场景';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pairs = OptionPair::query()->where('status',1)->get();
        $times = OptionTime::query()->where('status',1)->get();

        try {
        foreach ($pairs as $pair){
            if(blank($pair)) continue;

            $pair_id = $pair['pair_id'];

            foreach ($times as $time){
                $time_id = $time['time_id'];
                $start = Carbon::now();
                $end = Carbon::now()->addSeconds($time['seconds']);
                $range = date_range($start,$end,$time['seconds']);
                $new_date = Arr::first($range,function ($value, $key) use ($start) {
                    return $value >= $start;
                });
//                dd($range,$start->toDateTimeString(),$end->toDateTimeString(),$new_date,$next_date);
                if(!$new_date){
                    continue;
                }
                $carbon_obj = Carbon::parse($new_date);
                $begin_time = $carbon_obj->timestamp;
                $end_time = $carbon_obj->addSeconds($time['seconds'])->timestamp;

                $where = [
                    'pair_id' => $pair_id,
                    'time_id' => $time_id,
                    'begin_time' => $begin_time,
                ];

                $up_odds_data = [];
                $up_range = $time['odds_up_range'];
                foreach ($up_range as $key => $item){
                    $odds = $item['odds'];
                    $up_odds_data[$key] = ['uuid'=>Str::uuid(),'range'=>$item['range'],'odds'=>$odds,'up_down'=>1];
                }
                $down_odds_data = [];
                $down_range = $time['odds_down_range'];
                foreach ($down_range as $key => $item){
                    $odds = $item['odds'];
                    $down_odds_data[$key] = ['uuid'=>Str::uuid(),'range'=>$item['range'],'odds'=>$odds,'up_down'=>2];
                }
                $draw_odds_data = [];
                $draw_range = $time['odds_draw_range'];
                foreach ($draw_range as $key => $item){
                    $odds = $item['odds'];
                    $draw_odds_data[$key] = ['uuid'=>Str::uuid(),'range'=>$item['range'],'odds'=>$odds,'up_down'=>3];
                }

                $create_data = [
                    'scene_sn' => get_order_sn('scene'),
                    'time_id' => $time_id,
                    'seconds' => $time['seconds'],
                    'pair_id' => $pair_id,
                    'pair_time_name' => $pair['pair_name'] . '-' . $time['time_name'],
                    'up_odds' => $up_odds_data,
                    'down_odds' => $down_odds_data,
                    'draw_odds' => $draw_odds_data,
                    'begin_time' => $begin_time,
                    'end_time' => $end_time,
                ];

                $carbon_obj2 = Carbon::parse($new_date)->addSeconds($time['seconds']);
                $begin_time2 = $carbon_obj2->timestamp;
                $end_time2 = $carbon_obj2->addSeconds($time['seconds'])->timestamp;
                $where2 = [
                    'pair_id' => $pair_id,
                    'time_id' => $time_id,
                    'begin_time' => $begin_time2,
                ];
                $create_data2 = [
                    'scene_sn' => get_order_sn('scene'),
                    'time_id' => $time_id,
                    'seconds' => $time['seconds'],
                    'pair_id' => $pair_id,
                    'pair_time_name' => $pair['pair_name'] . '-' . $time['time_name'],
                    'up_odds' => $up_odds_data,
                    'down_odds' => $down_odds_data,
                    'draw_odds' => $draw_odds_data,
                    'begin_time' => $begin_time2,
                    'end_time' => $end_time2,
                ];

                $scene = OptionScene::query()->firstOrCreate($where,$create_data);
                $scene2 = OptionScene::query()->firstOrCreate($where2,$create_data2);
                if(!isset($scene['status'])){
                    //创建期权场景成功
                    Cache::store('redis')->put('get_begin_price:'.$scene->scene_id,$scene->scene_id,PriceCalculate($begin_time,'-',time())); // 获取期权周期开始价格
                    Cache::store('redis')->put('option_delivery:'.$scene->scene_id,$scene->scene_id,PriceCalculate($end_time,'-',time())); // 指定周期时间后--执行期权交割

//                    info("创建期权场景：" . $pair['symbol'] . '-' . $time['time_name'] . '-' . $scene['scene_id'] . '-' . Carbon::createFromTimestamp($begin_time)->toDateTimeString());
                }
                if(!isset($scene2['status'])){
                    //创建期权场景成功
                    Cache::store('redis')->put('get_begin_price:'.$scene2->scene_id,$scene2->scene_id,PriceCalculate($begin_time2,'-',time())); // 获取期权周期开始价格
                    Cache::store('redis')->put('option_delivery:'.$scene2->scene_id,$scene2->scene_id,PriceCalculate($end_time2,'-',time())); // 指定周期时间后--执行期权交割

//                    info("创建期权场景：" . $pair['symbol'] . '-' . $time['time_name'] . '-' . $scene['scene_id'] . '-' . Carbon::createFromTimestamp($begin_time)->toDateTimeString());
                }
            }
        }
        } catch (\Exception $e) {
            info($e);
        }

    }
}
