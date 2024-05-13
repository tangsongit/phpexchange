<?php

namespace App\SwooleWebsocket\Swap\Binance\Kline;

use App\SwooleWebsocket\Swap\Binance\Kline;

class Kline1h extends Kline
{
    public static $periods = [
        '1h' => ['period' => '60min', 'seconds' => 3600],
    ];
}
