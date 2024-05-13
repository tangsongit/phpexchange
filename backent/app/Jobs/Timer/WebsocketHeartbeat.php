<?php

namespace App\Jobs\Timer;

use Hhxsv5\LaravelS\Swoole\Timer\CronJob;

class WebsocketHeartbeat extends CronJob
{

    protected $i = 0;
    // !!! 定时任务的`interval`和`isImmediate`有两种配置方式（二选一）：一是重载对应的方法，二是注册定时任务时传入参数。
    // --- 重载对应的方法来返回配置：开始
    public function interval()
    {
        return 60 * 1000; // 每60秒运行一次
    }
    public function isImmediate()
    {
        return false; // 是否立即执行第一次，false则等待间隔时间后执行第一次
    }
    // --- 重载对应的方法来返回配置：结束
    public function run()
    {
        $swoole = app('swoole');
        foreach ($swoole->connections as $fd) {
            try {
                $swoole->push($fd, json_encode(['type' => 'ping']));
                $swoole->push($fd, json_encode(['cmd' => 'ping']));
            } catch (\Exception $e) {
                info($e);
            }
        }

        // 此处抛出的异常会被上层捕获并记录到Swoole日志，开发者需要手动try/catch
    }
}
