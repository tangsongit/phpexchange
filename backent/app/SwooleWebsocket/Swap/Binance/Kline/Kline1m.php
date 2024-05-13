<?php

namespace App\SwooleWebsocket\Swap\Binance\Kline;

use App\SwooleWebsocket\Swap\Binance\Kline;

class Kline1M extends Kline
{
    public static $periods = [
        '1M' => ['period' => '1mon', 'seconds' => 2592000],
    ];
}
