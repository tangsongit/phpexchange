<?php

namespace App\SwooleWebsocket\Swap\Binance\Kline;

use App\SwooleWebsocket\Swap\Binance\Kline;

class Kline1w extends Kline
{
    public static $periods = [
        '1w' => ['period' => '1week', 'seconds' => 604800],
    ];
}
