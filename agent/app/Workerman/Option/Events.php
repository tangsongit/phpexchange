<?php


namespace App\Workerman\Option;

use App\Models\Coins;
use App\Models\InsideTradePair;
use App\Models\OptionPair;
use App\Models\OptionScene;
use App\Models\OptionTime;
use App\Services\HuobiService\HuobiapiService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use \Workerman\Lib\Timer;
use GatewayWorker\Lib\Gateway;
use Workerman\Connection\AsyncTcpConnection;
use Workerman\Http\Client;

class Events
{
    const MAX_PACKAGE = 256;

    public static function onWorkerStart($businessWorker)
    {
        // Channel客户端连接到Channel服务端
        \Channel\Client::connect('127.0.0.1', 2306);
        // 监听全局分组发送消息事件
        \Channel\Client::on('send_to_group', function($event_data){
            $group_id = $event_data['group_id'];
            $message = $event_data['message'];
            global $group_con_map;
//            print_r(array_keys($group_con_map));
            if (isset($group_con_map[$group_id])) {
                foreach ($group_con_map[$group_id] as $client_id) {
                    Gateway::sendToClient($client_id, json_encode(['code'=>0,'msg'=>'success','data'=>$message,'sub'=>$group_id]));
                }
            }
        });
    }

    public static function onConnect($client_id)
    {

    }

    public static function getData($sub)
    {
        $type = str_before($sub,'_');

        switch ($type){
            case 'indexMarketList' : // 首页行情
                $market = [];
                $data = InsideTradePair::query()->where('status',1)->get()->groupBy('quote_coin_name')->toArray();
                $kk = 0;
                foreach ($data as $k => $items){
                    $coin = Coins::query()->where('coin_name',$k)->first();
                    $market[$kk]['coin_name'] = $coin['coin_name'];
                    $market[$kk]['full_name'] = $coin['full_name'];
                    $market[$kk]['coin_icon'] = getFullPath($coin['coin_icon']);
                    $market[$kk]['coin_content'] = $coin['coin_content'];
                    $market[$kk]['qty_decimals'] = $coin['qty_decimals'];
                    $market[$kk]['price_decimals'] = $coin['price_decimals'];
                    $quote_coin_name = strtolower($k);
                    foreach ($items as $key2 => $item){
                        $cd = Cache::store('redis')->tags('market_detail_' . $quote_coin_name)->get('market:' . $item['symbol'] . '_detail');
//                        $key = 'market:' . $item['symbol'] . '_newPrice';
//                        $cd = Cache::store('redis')->get($key);
                        $cd['qty_decimals'] = $item['qty_decimals'];
                        $cd['price_decimals'] = $item['price_decimals'];
                        $cd['min_qty'] = $item['min_qty'];
                        $cd['min_total'] = $item['min_total'];
                        $cd['coin_name'] = $item['base_coin_name'];
                        $cd['pair_id'] = $item['pair_id'];
                        $cd['pair_name'] = $item['pair_name'];
                        $cd['symbol'] = $item['symbol'];
                        $market[$kk]['marketInfoList'][$key2] = $cd;
                    }
                    $kk++;
                }
                return $market;
                break;
            case 'marketList' : //期权市场行情
                $market = [];
                $data = OptionPair::query()->where('status',1)->get()->groupBy('quote_coin_name')->toArray();
                $kk = 0;
                foreach ($data as $k => $items){
                    $coin = Coins::query()->where('coin_name',$k)->first();
                    $market[$kk]['coin_name'] = $coin['coin_name'];
                    $market[$kk]['full_name'] = $coin['full_name'];
                    $market[$kk]['coin_icon'] = getFullPath($coin['coin_icon']);
                    $market[$kk]['coin_content'] = $coin['coin_content'];
                    $market[$kk]['qty_decimals'] = $coin['qty_decimals'];
                    $market[$kk]['price_decimals'] = $coin['price_decimals'];
                    $quote_coin_name = strtolower($k);
                    foreach ($items as $key2 => $item){
//                        $cd = Cache::store('redis')->tags('market_detail_' . $quote_coin_name)->get('market:' . $item['symbol'] . '_detail');
                        $key = 'market:' . $item['symbol'] . '_newPrice';
                        $cd = Cache::store('redis')->get($key);
                        $cd['qty_decimals'] = $item['qty_decimals'];
                        $cd['price_decimals'] = $item['price_decimals'];
                        $cd['min_qty'] = $item['min_qty'];
                        $cd['min_total'] = $item['min_total'];
                        $cd['coin_name'] = $item['base_coin_name'];
                        $cd['pair_id'] = $item['pair_id'];
                        $cd['pair_name'] = $item['pair_name'];
                        $cd['symbol'] = $item['symbol'];
                        $market[$kk]['marketInfoList'][$key2] = $cd;
                    }

                    $kk++;
                }
                return $market;
                break;
            case 'newPrice' : // 期权最新价格
                $params = str_after($sub,'_');
                $pair = OptionPair::query()->find($params);
                if(blank($pair)) return [];
                $symbol = strtolower($pair['base_coin_name']) . strtolower($pair['quote_coin_name']);
//              $symbol = 'btcusdt';

                $key = 'market:' . $symbol . '_newPrice';
                $data = Cache::store('redis')->get($key);
//                $data['ts'] = (int)(microtime(true)*1000);
//                list($sec, $msec) = explode(' ', microtime());
//                $data['ts'] = ($sec * 1000 + $msec);
                $data['ts'] = Carbon::now()->getPreciseTimestamp(3);
                return $data;
                break;
            case 'sceneListNewPrice' : // 期权所有场景最新价格
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
                break;
            case 'Kline' : // 期权Kline
                $params = str_after($sub,'_');
                $pair_id = str_before($params,'_');
                $period = str_after($params,'_');
                $pair = OptionPair::query()->find($pair_id);
                if(blank($pair)) return [];
                $symbol = strtolower($pair['base_coin_name']) . strtolower($pair['quote_coin_name']);

                $key = 'market:' . $symbol . '_kline_' . $period;
                return Cache::store('redis')->get($key);
                break;
            case 'exchangeMarketList' : // 币币市场行情
                $market = [];
                $data = InsideTradePair::query()->where('status',1)->get()->groupBy('quote_coin_name')->toArray();
                $kk = 0;
                foreach ($data as $k => $items){
                    $coin = Coins::query()->where('coin_name',$k)->first();
                    $market[$kk]['coin_name'] = $coin['coin_name'];
                    $market[$kk]['full_name'] = $coin['full_name'];
                    $market[$kk]['coin_icon'] = getFullPath($coin['coin_icon']);
                    $market[$kk]['coin_content'] = $coin['coin_content'];
                    $market[$kk]['qty_decimals'] = $coin['qty_decimals'];
                    $market[$kk]['price_decimals'] = $coin['price_decimals'];
                    $quote_coin_name = strtolower($k);
                    foreach ($items as $key2 => $item){
//                        $cd = Cache::store('redis')->tags('market_detail_' . $quote_coin_name)->get('market:' . $item['symbol'] . '_detail');
                        $key = 'market:' . $item['symbol'] . '_newPrice';
                        $cd = Cache::store('redis')->get($key);
                        $cd['qty_decimals'] = $item['qty_decimals'];
                        $cd['price_decimals'] = $item['price_decimals'];
                        $cd['min_qty'] = $item['min_qty'];
                        $cd['min_total'] = $item['min_total'];
                        $cd['coin_name'] = $item['base_coin_name'];
                        $cd['pair_id'] = $item['pair_id'];
                        $cd['pair_name'] = $item['pair_name'];
                        $cd['symbol'] = $item['symbol'];
                        $market[$kk]['marketInfoList'][$key2] = $cd;
                    }
                    $kk++;
                }
                return $market;
                break;
            case 'buyList' : // 币币买盘
                $params = str_after($sub,'_');
                $pair = InsideTradePair::query()->find($params);
                $symbol = strtolower($pair['base_coin_name']) . strtolower($pair['quote_coin_name']);

                $key = 'market:' . $symbol . '_depth_buy';
                return cache::store('redis')->get($key);
                break;
            case 'sellList' : // 币币卖盘
                $params = str_after($sub,'_');
                $pair = InsideTradePair::query()->find($params);
                $symbol = strtolower($pair['base_coin_name']) . strtolower($pair['quote_coin_name']);

                $key = 'market:' . $symbol . '_depth_sell';
                return cache::store('redis')->get($key);
                break;
            case 'tradeList' : // 币币成交明细
                $params = str_after($sub,'_');
                $pair = InsideTradePair::query()->find($params);
                $symbol = strtolower($pair['base_coin_name']) . strtolower($pair['quote_coin_name']);

                $key = 'market:' . $symbol . '_trade_detail';
                return cache::store('redis')->get($key);

                break;
            case 'exchangeKline' : // 币币Kline
                $params = str_after($sub,'_');
                $pair_id = str_before($params,'_');
                $period = str_after($params,'_');
                $pair = InsideTradePair::query()->find($pair_id);
                if(blank($pair)) return [];
                $symbol = strtolower($pair['base_coin_name']) . strtolower($pair['quote_coin_name']);

                $key = 'market:' . $symbol . '_kline_' . $period;
                return Cache::store('redis')->get($key);
                break;
        }
    }

    public static function getMarketList($type = 'marketList')
    {
        $market = [];
        $data = InsideTradePair::query()->where('status',1)->get()->groupBy('quote_coin_name')->toArray();
        $kk = 0;
        foreach ($data as $k => $items){
            $coin = Coins::query()->where('coin_name',$k)->first();
            $market[$kk]['coin_name'] = $coin['coin_name'];
            $market[$kk]['full_name'] = $coin['full_name'];
            $market[$kk]['coin_icon'] = getFullPath($coin['coin_icon']);
            $market[$kk]['coin_content'] = $coin['coin_content'];
            $market[$kk]['qty_decimals'] = $coin['qty_decimals'];
            $market[$kk]['price_decimals'] = $coin['price_decimals'];
            $quote_coin_name = strtolower($k);
            foreach ($items as $key2 => $item){
//                $cd = Cache::store('redis')->tags('market_detail_' . $quote_coin_name)->get('market:' . $item['symbol'] . '_detail');
                $key = 'market:' . $item['symbol'] . '_newPrice';
                $cd = Cache::store('redis')->get($key);
                $cd['qty_decimals'] = $item['qty_decimals'];
                $cd['price_decimals'] = $item['price_decimals'];
                $cd['min_qty'] = $item['min_qty'];
                $cd['min_total'] = $item['min_total'];
                $cd['coin_name'] = $item['base_coin_name'];
                $cd['pair_id'] = $item['pair_id'];
                $cd['pair_name'] = $item['pair_name'];
                $cd['symbol'] = $item['symbol'];
                $market[$kk]['marketInfoList'][$key2] = $cd;
            }
            $kk++;
        }
        return $market;
    }

    public static function onWebSocketConnect($client_id, $data)
    {
        echo "onWebSocketConnect\r\n";
    }

    public static function onMessage($client_id, $message)
    {
        if (strlen($message) > Events::MAX_PACKAGE) Gateway::closeClient($client_id);
        echo $message . "onMessage\r\n";
        $message = json_decode($message);

        if(isset($message->cmd)){
            switch ($message->cmd){
                case 'pong' :
                    Gateway::sendToClient($client_id, json_encode(['code'=>0,'msg'=>'success']));
                    break;
                case 'sub' :
                    $sub = $message->msg;
                    $type = str_before($sub,'_');

                    // 市场行情
                    if($type == 'marketList' || $type == 'indexMarketList' || $type == 'exchangeMarketList'){
                        $time_interval = 1;
                        $_SESSION['market'][$sub] = Timer::add($time_interval, function()use($client_id,$type,$sub)
                        {
                            $data = Events::getMarketList($type);
                            $message = json_encode(['code'=>0,'msg'=>'success','data'=>$data,'sub'=>$sub]);
                            Gateway::sendToClient($client_id,$message);
                        });
                    }else{
                        global $group_con_map;
                        // 将连接加入到对应的群组数组里
                        $group_con_map[$sub][$client_id] = $client_id;
                        // 记录这个连接加入了哪些群组，方便在onclose的时候清理group_con_map对应群组的数据
                        $_SESSION['sub'][] = $sub;
                    }

                    break;
                case 'unsub' :
                    $sub = $message->msg;
                    $type = str_before($sub,'_');

                    // 市场行情
                    if($type == 'marketList' || $type == 'indexMarketList' || $type == 'exchangeMarketList'){
                        if(!blank($market_time_id = array_get($_SESSION['market'], $sub))){
                            array_forget($_SESSION['market'], $sub);
                            //删除定时器
                            Timer::del($market_time_id);
                        }
                    }else{
                        global $group_con_map;
                        // 遍历连接加入的所有群组，从group_con_map删除对应的数据
                        if (isset($_SESSION['sub'])) {
                            unset($group_con_map[$sub][$client_id]);
                            $_SESSION['sub'] = array_diff($_SESSION['sub'],[$sub]);

                            if (empty($group_con_map[$sub])) {
                                unset($group_con_map[$sub]);
                            }
                        }
                    }

                    break;
                case 'req' :
                    $ch = $message->msg;
                    $type = str_before($ch,'_');
                    if($type == 'tradeList'){
                        $params = str_after($ch,'_');
                        $pair = InsideTradePair::query()->find($params);
                        $symbol = strtolower($pair['base_coin_name']) . strtolower($pair['quote_coin_name']);
                        // 火币最新成交明细缓存
                        $new_price_book_key = 'market:' . $symbol . '_newPriceBook';
                        $new_price_book = Cache::store('redis')->get($new_price_book_key);
                        Gateway::sendToClient($client_id, json_encode(['code'=>0,'msg'=>'success','data'=>$new_price_book,'sub'=>$ch,'type'=>'history']));
                    }elseif($type == 'Kline'){
                        $params = str_after($ch,'_');
//                        $pair_id = str_before($params,'_');
//                        $period = str_after($params,'_');
//                        $pair = InsideTradePair::query()->find($pair_id);
//                        $symbol = strtolower($pair['base_coin_name']) . strtolower($pair['quote_coin_name']);
                        $symbol = str_before($params,'_');
                        $period = str_after($params,'_');
                        if(blank($symbol) || blank($period)){
                            Gateway::sendToClient($client_id, json_encode(['code'=>-1,'msg'=>'params error']));
                            break;
                        }

                        $kline_book = Cache::store('redis')->get('market:' . $symbol . '_kline_book_' . $period);
                        Gateway::sendToClient($client_id, json_encode(['code'=>0,'msg'=>'success','data'=>$kline_book,'sub'=>$ch,'type'=>'history']));
                    }

                    break;
            }
        }
        return true;
    }

    public static function onClose($client_id)
    {
//        if(isset($_SESSION['data_time_id'])) Timer::del($_SESSION['data_time_id']);
//        if(isset($_SESSION['sub'])){
//            unset($_SESSION['sub']);
//            Timer::delAll();
//        }
        global $group_con_map;
        // 遍历连接加入的所有群组，从group_con_map删除对应的数据
        if (isset($_SESSION['sub'])) {
            foreach ($_SESSION['sub'] as $sub) {
                unset($group_con_map[$sub][$client_id]);
            }
            if (empty($group_con_map[$sub])) {
                unset($group_con_map[$sub]);
            }
        }
        GateWay::closeClient($client_id);
    }
}
