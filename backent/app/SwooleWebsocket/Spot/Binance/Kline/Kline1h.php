<?php

namespace App\SwooleWebsocket\Spot\Binance\Kline;

use App\SwooleWebsocket\Spot\Binance\Kline;

class Kline1h extends Kline
{
    public static $periods = [
        '1h' => ['period' => '60min', 'seconds' => 3600],
    ];
}
