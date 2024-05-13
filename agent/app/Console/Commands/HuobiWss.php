<?php

namespace App\Console\Commands;

use App\Models\InsideTradePair;
use App\Models\OptionPair;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Workerman\Worker;
use Workerman\Connection\AsyncTcpConnection;

class HuobiWss extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'huobiWss';

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
                $msg = [
                    "sub"=> "market.btcusdt.kline.15min",
//                    "req"=> "market.ethbtc.kline.5min",
                    "id"=> $con->id,
//                    "from" => 1594022521,
//                    "to" => 1594063918
                ];
                $con->send(json_encode($msg));
            };

            $con->onMessage = function($con, $data) {
                $data =  json_decode(gzdecode($data),true);
                echo json_encode($data) . "\r\n";
                if(isset($data['ping'])){
                    $msg = ["pong" => $data['ping']];
                    $con->send(json_encode($msg));
                }
                if(isset($data['ch'])){
                    $ch = $data['ch'];
                    $pattern_kline = '/^market\.(.*?)\.kline\.([\s\S]*)/'; //Kline
                    if (preg_match($pattern_kline, $ch, $match_kline)){
                        $symbol = $match_kline[1];
                        $period = $match_kline[2];
                        $group = 'market:' . $symbol . '_kline_' . $period;
                    }
                    $group_id = 'market.btcusdt.kline.15min';
                    \Channel\Client::connect('211.149.170.186', 9090);
                    // Channel\Client给所有服务器的所有进程广播分组发送消息事件
                    \Channel\Client::publish('send_to_group', array(
                        'group_id'=>$group_id,
                        'message'=>$data
                    ));
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
