<?php

namespace App\SwooleWebsocket\Swap\Binance\Kline;

use App\SwooleWebsocket\Swap\Binance\Kline;

class Kline15m extends Kline
{
    public static $periods = [
        '15m' => ['period' => '15min', 'seconds' => 900],
    ];
}
