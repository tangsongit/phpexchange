<?php

namespace App\SwooleWebsocket\Spot\Binance\Kline;

use App\SwooleWebsocket\Spot\Binance\Kline;

class Kline1w extends Kline
{
    public static $periods = [
        '1w' => ['period' => '1week', 'seconds' => 604800],
    ];
}
