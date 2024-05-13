<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-09-03 16:33:13
 */


namespace App\Services\ExchangeRateService;


use App\Services\ExchangeRateService\lib\Fxhapi;
use App\Traits\RedisTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ExchangeRateService
{
    use RedisTool;

    private $server;

    private $ttl = 60;

    public function __construct()
    {
        $this->server = new Fxhapi();
    }

    public function getCurrencyExCny_copy($coin_name)
    {
        $tickers = $this->getTickers();
        return array_first($tickers ?? [], function ($value, $key) use ($coin_name) {
            return $value['symbol'] == $coin_name;
        });
    }

    public function getCurrencyExCny($coin_name)
    {
        $tickers = $this->getTickers() ?? [];
        return array_first($tickers, function ($value, $key) use ($coin_name) {
            return $value['symbol'] == $coin_name;
        });
    }

    private function getTickers($currency = 'cny')
    {
        $key = 'ExchangeRate_' . $currency;

        if (Cache::has($key)) {
            $result = Cache::get($key);
        } else {
            $result = $this->server->getTickers($currency);
            Cache::put($key, $result, 60);
        }

        return $result;
    }

    //判断过期
    private function ifTtl($key, $ttlSeconds)
    {
        $ttl = $this->getTTL($key);
        if (
            $ttl <= 0
            || ($this->ttl - $ttl > $ttlSeconds)
        ) {
            if ($this->setKeyLock($key . ':lock', 3))
                return 1; //过期,同时只能有一人更新
            return 0;
        }
        return 0; //未过期
    }
}
