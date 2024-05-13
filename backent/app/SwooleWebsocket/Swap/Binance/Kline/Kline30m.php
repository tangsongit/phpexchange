<?php

namespace App\SwooleWebsocket\Swap\Binance\Kline;

use App\SwooleWebsocket\Swap\Binance\Kline;

class Kline30m extends Kline
{
    public static $periods = [
        '30m' => ['period' => '30min', 'seconds' => 1800],
    ];
}
