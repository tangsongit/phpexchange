<?php

namespace App\Pool\Core;

class CoRedis
{
    protected $pool;

    private $redis;

    public function __construct($pool)
    {
        $this->pool = $pool;
    }

    public function connection()
    {
        return $this->pool->get();
    }
    public function getRedis()
    {
        return $this->redis = $this->connection();
    }
    public function __call($name, $arguments)
    {
        if (!method_exists($this, $name)) {
            throw new \RuntimeException("{$name} Method doesn't exist!");
        }
        call_user_func("getReids");
        call_user_func_array([$this, $name], $arguments);
    }
}
