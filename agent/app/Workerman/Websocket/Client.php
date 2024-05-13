<?php namespace App\Workerman\Websocket;

use Channel\Client as WS;

class Client
{

    static function send($message = []){
        WS::connect('127.0.0.1', 9091);
        WS::publish('broadcast', ['content' => json_encode($message)]);
    }
}
