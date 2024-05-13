<?php

namespace App\SwooleWebsocket\Spot\Binance\Kline;

use App\SwooleWebsocket\Spot\Binance\Kline;

class Kline30m extends Kline
{
    public static $periods = [
        '30m' => ['period' => '30min', 'seconds' => 1800],
    ];
}
