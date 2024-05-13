<?php

namespace App\Pool;

use Swoole\Coroutine\Channel;
use Swoole\Coroutine;
use Swoole\Runtime;

class Redis
{
    public static function getDriver()
    {
        return app(app('config')->get("database.redis.default.driver"));
    }
    public static function __callStatic($name, $arguments)
    {
        Runtime::enableCoroutine();
        $chan = new Channel(1);
        Coroutine::create(function () use ($chan, $name, $arguments) {
            $redis = self::getDriver();
            $return = $redis->{$name}(...$arguments);
            $chan->push($return);
            return $chan->pop();
        });
    }
}
