<?php

namespace App\Jobs\Timer\Spot;

use App\Jobs\Timer\Spot\Common;
use App\Models\OptionScene;
use App\Models\OptionTime;
use App\SwooleWebsocket\WebsocketGroup;
use Illuminate\Support\Facades\Cache;

class SceneListNewPrice extends Common
{
    public function run()
    {
        OptionTime::query()->where('option_time.status', 1) //期权最新价格
            ->where('option_pair.status', 1)
            ->select(['option_pair.pair_id', 'option_pair.pair_name', 'option_pair.symbol', 'option_time.time_id', 'option_time.time_name', 'option_time.seconds'])
            ->crossJoin('option_pair')
            ->get()
            ->map(function ($option) {
                $group_id = 'sceneListNewPrice';
                $cache_data = Cache::store('redis')->get('market:' . $option['symbol'] . '_newPrice');
                // if (WebsocketGroup::getClientIdCountByGroup($group_id) > -1) {
                $scene = OptionScene::query()->where([
                    ['time_id', '=', $option['time_id']],
                    ['pair_id', '=', $option['pair_id']],
                    ['end_time', '>=', time()],
                    ['end_time', '<', time() + $option['seconds']],
                ])->first();
                if (blank($scene)) {
                    $data = [];
                } else {
                    $data = [
                        'time_id' => $option['time_id'],
                        'pair_id' => $option['pair_id'],
                        'time_name' => $option['time_name'],
                        'pair_name' => $option['pair_name'],
                        'symbol' => $option['symbol'],
                        'pair_time_name' => $scene['pair_time_name'],
                        'upodds' => $scene['up_odds'][0]['odds'],
                        'downodds' => $scene['down_odds'][0]['odds'],
                        'increase' => $cache_data['increase'],
                        'increaseStr' => $cache_data['increaseStr'],
                        'trend_up' => mt_rand(10, 99) / 100,
                    ];
                    $data['trend_down'] = round(1 - $data['trend_up'], 2);
                }
                $message = json_encode(['code' => 0, 'msg' => 'success', 'data' => $data, 'sub' => $group_id]);
                WebsocketGroup::sendToGroup($group_id, $message);
                // }
            });
    }
}
