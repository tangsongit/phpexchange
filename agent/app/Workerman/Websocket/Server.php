<?php namespace App\Workerman\Websocket;

use Workerman\Worker;
use Workerman\Lib\Timer;


class Server{

    const HEARTBEAT_LIMIT = 30;
    const MAX_PACKAGE = 256;

    static $uid = [];     # 用于绑定用户UID.
    static $connection = [];     # 用于设置与连接相关的参数

    static $subscribe = [
        'market',
        'buyList',
        'sellList',
        'tradeList',
    ];

    static function start()
    {
        $namespace = '\App\Workerman\Websocket';
        $worker                = new Worker('websocket://0.0.0.0:8088');
        $worker->count         = 2;
        $worker->name          = 'websocket';
        $worker->onWorkerStart = $namespace.'\Server::onWorkerStart';
        $worker->onConnect     = $namespace.'\Server::onConnect';
        $worker->onMessage     = $namespace.'\Server::onMessage';
        $worker->onClose       = $namespace.'\Server::onClose';
        $worker->onError       = $namespace.'\Server::onError';

        // 多进程下管理端口
        $channel_server = new \Channel\Server('127.0.0.1', 9091);

        Worker::runAll();
    }

    static function onWorkerStart($worker)
    {
        Timer::add(Server::HEARTBEAT_LIMIT, function () use ($worker) {
            $time_now = time();
            foreach ($worker->connections as $connection) {
                // 有可能该connection还没收到过消息，则lastMessageTime设置为当前时间
                if (empty($connection->lastMessageTime)) {
                    $connection->lastMessageTime = $time_now;
                    continue;
                }
                // 上次通讯时间间隔大于心跳间隔，则认为客户端已经下线，关闭连接
                if ($time_now - $connection->lastMessageTime > Server::HEARTBEAT_LIMIT+5) {
                    $connection->close();
                }
            }
        });

        \Channel\Client::connect('127.0.0.1', 9091);
        \Channel\Client::on("broadcast", function($data)use($worker){
            foreach ($worker->connections as $connection) {
                $connection->send($data['content']);
            }
        });
    }

    static function onConnect($connection)
    {
        print($connection->id.": new connection in \n");
        $connection->onWebSocketConnect = function($connection , $http_header) {
            // 可以在这里判断连接来源是否合法，不合法就关掉连接
            // $_SERVER['HTTP_ORIGIN']标识来自哪个站点的页面发起的websocket连接
            print($_SERVER['HTTP_ORIGIN']."\n");
//            if($_SERVER['HTTP_ORIGIN'] != env('APP_URL','http://www.bourse.com') ){
//                $connection->close();
//            }
        };

        self::$connection[$connection->id]['message_timer_id'] = Timer::add(1, function () use ($connection) {
//            print($connection->subscribe."\n");
            if(isset($connection->subscribe) && in_array('buyList',$connection->subscribe)){
                $connection->send(json_encode(['code'=>0,'msg'=>'success','data'=>'1','sub'=>'buyList'],320));
            }

        });
    }

    static function onMessage($connection, $message)
    {
        if (strlen($message) > Server::MAX_PACKAGE) $connection->destroy();

        $message = json_decode($message);
        $connection->lastMessageTime = time();

        if(isset($message->cmd)){
            switch ($message->cmd){
                case 'heartbeat' :
                    $connection->send(json_encode(['cmd'=>'heartbeat','msg'=>time()],320));
                    break;
                case 'sub' :
                    $connection->subscribe[] = $message->msg;
                    $connection->send(json_encode(['cmd'=>'sub','msg'=>'subscribe complete','subscribe'=>$connection->subscribe], 320));
                    break;
                case 'unsub' :
                    $connection->subscribe[] = array_diff($connection->subscribe, [$message->msg]);
                    $connection->send(json_encode(['cmd'=>'unsub','msg'=>'unsubscribe complete','subscribe'=>$connection->subscribe], 320));
                    break;
            }
        }
        return true;
    }

    static function onClose($connection)
    {
        Timer::del(self::$connection[$connection->id]['message_timer_id']);
        print($connection->id.": connection close\n");
    }

    static function onError($connection){

    }
}
