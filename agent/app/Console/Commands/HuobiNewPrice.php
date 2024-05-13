<?php

namespace App\Console\Commands;

use App\Models\InsideTradePair;
use App\Models\OptionPair;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Workerman\Connection\AsyncTcpConnection;
use Workerman\Worker;

class HuobiNewPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'huobiNewPrice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $worker = new Worker();

        $worker->onWorkerStart = function($worker){

            $con = new AsyncTcpConnection('ws://api.hadax.com/ws');

            // 设置以ssl加密方式访问，使之成为wss
            $con->transport = 'ssl';

            $con->onConnect = function($con) {

                //期权最新价格数据
                $option_pairs = OptionPair::query()->where('status',1)->get();
                foreach ($option_pairs as $pair){
                    $symbol = strtolower($pair['base_coin_name'] . $pair['quote_coin_name']);
                    $msg = ["sub"=> "market." . $symbol . ".trade.detail", "id"=> $con->id];
                    $con->send(json_encode($msg));
                }
            };

            $con->onMessage = function($con, $data) {
                $data =  json_decode(gzdecode($data),true);
//                echo $data . "\r\n";
                if(isset($data['ping'])){
                    $msg = ["pong" => $data['ping']];
                    $con->send(json_encode($msg));
                }
                if(isset($data['ch'])){
                    $ch = $data['ch'];
                    $pattern_detail = '/^market\.(.*?)\.detail$/'; //市场概要
//                    $pattern_newPrice = '/^market\.(.*?)\.trade\.detail$/'; //期权最新价格
                    if(preg_match($pattern_detail, $ch, $match_detail)){
                        $match = $match_detail[1];
                        $symbol = str_before($match,'.');
                        $after = str_after($match,'.');
                        if( $after == 'trade' ){
                            //期权最新价格
//                            echo json_encode($match_detail) . "\r\n";
                            $key = 'market:' . $symbol . '_newPrice';
                            if(blank($data['tick'])){
                                $cache_data = [];
                            }else{
                                $cache_data = $data['tick']['data'][0];
                                $cache_data['ts'] = Carbon::now()->getPreciseTimestamp(3);

                                $last_cache_data = Cache::store('redis')->get($key);
                                if($last_cache_data){
                                    $increase = PriceCalculate(($last_cache_data['price'] - $cache_data['price']) ,'/', $last_cache_data['price'],2);
                                    $cache_data['increase'] = $increase;
                                    $cache_data['increaseStr'] = $increase * 100 . '%';
                                }
                            }
                            echo json_encode($cache_data) . "\r\n";
                            Cache::store('redis')->put($key,$cache_data);

                            //缓存历史价格数据book
                            $history_data_key = 'market:' . $symbol . '_newPriceBook';
                            $old_cache_data = Cache::store('redis')->get($history_data_key);
                            if(!$old_cache_data){
                                //第一条
                                Cache::store('redis')->put($history_data_key,[$cache_data]);
                            }else{
                                //追加
                                array_push($old_cache_data,$cache_data);
                                echo gettype($old_cache_data) . "\r\n";
                                echo count($old_cache_data) . "\r\n";
                                if(count($old_cache_data) > 200){
                                    array_shift($old_cache_data);
                                }
                                Cache::store('redis')->put($history_data_key,$old_cache_data);
                            }
                        }
                    }
                }
            };

            $con->onClose = function ($con) {
                //这个是延迟断线重连，当服务端那边出现不确定因素，比如宕机，那么相对应的socket客户端这边也链接不上，那么可以吧1改成适当值，则会在多少秒内重新，我也是1，也就是断线1秒重新链接
                $con->reConnect(1);
            };

            $con->onError = function ($con, $code, $msg) {
                echo "error $code $msg\n";
            };

            $con->connect();
        };

        Worker::runAll();
    }
}
