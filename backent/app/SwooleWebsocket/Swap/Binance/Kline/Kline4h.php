<?php

namespace App\SwooleWebsocket\Swap\Binance\Kline;

use App\SwooleWebsocket\Swap\Binance\Kline;

class Kline4h extends Kline
{
    public static $periods = [
        '4h' => ['period' => '4hour', 'seconds' => 14400],
    ];
}
