<?php

namespace App\SwooleWebsocket\Swap\Binance\Kline;

use App\SwooleWebsocket\Swap\Binance\Kline;

class Kline5m extends Kline
{
    public static $periods = [
        '5m' => ['period' => '5min', 'seconds' => 300],
    ];
}
