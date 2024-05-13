<?php

namespace App\SwooleWebsocket\Spot\Binance\Kline;

use App\SwooleWebsocket\Spot\Binance\Kline;

class Kline1d extends Kline
{
    public static $periods = [
        '1d' => ['period' => '1day', 'seconds' => 86400],
    ];
}
