<?php

namespace  App\Services;

use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;
use App\SwooleWebsocket\WebsocketGroup;

class WebsocketService implements WebSocketHandlerInterface
{

    public function __construct()
    {
        // (new \App\SwooleWebsocket\Spot\Collection\Huobi\Depth())->start();
    }
    // public function onHandShake(Request $request, Response $response)
    // {
    // 自定义握手：https://wiki.swoole.com/#/websocket_server?id=onhandshake
    // 成功握手之后会自动触发onOpen事件
    // }
    public function onOpen(Server $server, Request $request)
    {
        $server->push($request->fd, 'Connect success');
    }
    public function onMessage(Server $server, Frame $frame)
    {
        // 加入群组
        $data = json_decode($frame->data, true);
        $fd = $frame->fd;
        if (isset($data['cmd'], $data['msg'])) {
            $cmd = $data['cmd'];
            $msg = $data['msg'];
            if ($cmd == 'sub') { //加入群组
                WebsocketGroup::addGroup($msg, $fd);
            } elseif ($cmd = 'unsub') {
                WebsocketGroup::leaveGroup($msg, $fd);
            }
        }

        $pingFrame = new Frame;
        $pingFrame->opcode = WEBSOCKET_OPCODE_PING;
        $server->push($frame->fd, $pingFrame);
    }
    public function onClose(Server $server, $fd, $reactorId)
    {
    }
}
