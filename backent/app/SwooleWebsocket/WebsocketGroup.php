<?php

namespace App\SwooleWebsocket;

use Illuminate\Support\Facades\Redis;
use Swoole\WebSocket\Server;

class WebsocketGroup
{

    public static $typeMap = [
        'spot' => 'Websocket_group_spot',
        'swap' => 'Websocket_group_swap',
    ];

    // Websocket组地图
    public static $groupMap = [
        'spot' => [
            'kline' => 'Kline_ :pair _ :period ', //k线数据 （币对小写）
            'buyList' => 'buyList_ :pair ', //买盘深度  （币对小写）
            'sellList' => 'sellList_ :pair ', //卖盘深度    （币对小写）
            'trade'    => 'tradeList_ :pair', //最新成交价  （币对小写）
            'exchangeMarketList' => 'exchangeMarketList', //市场行情
            'indexMarketList'   => 'indexMarketList', //市场行情
            'sceneListNewPrice' => 'sceneListNewPrice', //期权交易最近价格
            'newPrice'      => 'newPrice_ :pair ', //币币对最新价格 （币对小写）
        ],
        'swap' => [
            'kline' => 'swapKline_ :symbol _ :period ', //k线数据 （币种大写）
            'buyList' => 'swapBuyList_ :symbol ', //买盘深度    （币种大写）
            'sellList' => 'swapSellList_ :symbol ', //卖盘深度  （币种大写）
            'trade'    => 'swapTradeList_ :symbol', //最新成交价 （币种大写）
            'swapMarketList' => 'swapMarketList', //市场行情
        ]
    ];

    // 加入组
    public static function addGroup($group, $fd)
    {
        // Redis::sadd($group, $fd);
        app('redis')->sadd($group, $fd);
    }
    // 离开组
    public static function leaveGroup($group, $fd)
    {
        // Redis::srem($group, $fd);
        app('redis')->srem($group, $fd);
    }
    // 组播
    public static function sendToGroup($group, $data)
    {
        $swoole = app('swoole');
        // $fds = Redis::smembers($group);
        $fds = app('redis')->smembers($group);
        foreach ($fds as $fd) {
            if ($swoole->isEstablished($fd)) { //检查是否在线
                $swoole->push($fd, $data);
            } else {
                self::leaveGroup($group, $fd);
            }
        }
    }
    // 获取组内连接人数
    public static function getClientIdCountByGroup($group)
    {
        $swoole = app('swoole');
        $count = 0;
        foreach (Redis::smembers($group) as $fd) {
            if ($swoole->isEstablished($fd)) {
                $count + 1;
            } else {
                self::leaveGroup($group, $fd);
            }
        }
        return $count;
    }
}
