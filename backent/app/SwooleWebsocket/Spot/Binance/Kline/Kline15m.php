<?php

namespace App\SwooleWebsocket\Spot\Binance\Kline;

use App\SwooleWebsocket\Spot\Binance\Kline;

class Kline15m extends Kline
{
    public static $periods = [
        '15m' => ['period' => '15min', 'seconds' => 900],
    ];
}
