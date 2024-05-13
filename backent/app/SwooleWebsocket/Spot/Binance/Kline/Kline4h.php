<?php

namespace App\SwooleWebsocket\Spot\Binance\Kline;

use App\SwooleWebsocket\Spot\Binance\Kline;

class Kline4h extends Kline
{
    public static $periods = [
        '4h' => ['period' => '4hour', 'seconds' => 14400],
    ];
}
