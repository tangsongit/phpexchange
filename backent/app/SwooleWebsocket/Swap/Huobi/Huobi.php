<?php

namespace App\SwooleWebsocket\Swap\Huobi;

use App\Models\InsideTradePair;
use App\SwooleWebsocket\WebsocketGroup;
use Hhxsv5\LaravelS\Swoole\Process\CustomProcessInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Swoole\Coroutine\Http\Client;
use Swoole\Coroutine;
use Swoole\Http\Server;
use Swoole\Process;

use function Swoole\Coroutine\run;

class Huobi implements CustomProcessInterface
{


    private static $quit = false;

    protected static $host = 'api.btcgateway.pro';
    protected static $port = '443';
    protected static $ssl = true;
    protected static $path = '/linear-swap-ws';

    protected static $client;
    protected static $ret;

    public static function callback(Server $swoole, Process $process)
    {
        static::connection();
        if (static::$ret) {
            static::push(); //发送订阅信息
            while (!self::$quit) {
                $recv = static::$client->recv();
                if ($recv == false) static::connection(); //如果连接断开立刻重连

                $data = @json_decode(gzdecode($recv->data), true);
                if (isset($data['ping'])) { //响应心跳数据
                    static::$client->push(json_encode(['pong' => $data['ping']]));
                }
                if (isset($data['ch'])) { //如果收到订阅信息
                    static::recv_ch($data);
                } elseif (isset($data['rep'])) { //如果收到请求返回信息rep
                    static::recv_rep($data);
                }
            }
        }
    }
    public static function onReload(Server $swoole, Process $process)
    {
        info('Test process: reloading');
        static::$quit = true;
    }
    public static function onStop(Server $swoole, Process $process)
    {
        info('Test process:stopping');
        static::$quit = true;
    }

    // 配置服务器信息
    public static function config()
    {
    }
    // 创建连接
    public static function connection()
    {
        echo __CLASS__ . "触发连接 \n";
        if (!blank(static::$client)) static::$client->close(); //如果存在连接，那么将其关闭后创建
        static::$client = new Client(static::$host, static::$port, static::$ssl);
        static::$ret = static::$client->upgrade(static::$path);
        if (static::$ret) {
            static::push(); //发送订阅信息
        } else {
            echo __CLASS__ . "触发重连 \n";
            self::connection();
        }
    }

    // 用于向服务器发送数据
    public static function push()
    {
        echo '请自定义发送数据';
    }
    // 接受订阅消息
    public static function recv_ch($data)
    {
    }
    // 接受请求消息
    public static function recv_rep($data)
    {
    }
}
