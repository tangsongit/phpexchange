<?php

namespace App\SwooleWebsocket\Swap\Binance\Kline;

use App\SwooleWebsocket\Swap\Binance\Kline;

class Kline1d extends Kline
{
    public static $periods = [
        '1d' => ['period' => '1day', 'seconds' => 86400],
    ];
}
