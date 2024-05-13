<?php

namespace App\SwooleWebsocket\Spot\Binance\Kline;

use App\SwooleWebsocket\Spot\Binance\Kline;

class Kline5m extends Kline
{
    public static $periods = [
        '5m' => ['period' => '5min', 'seconds' => 300],
    ];
}
