<?php


namespace App\Workerman\Option;


use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use Workerman\Worker;

class Option
{
    protected $serviceName = 'option';

    public function start()
    {
        // 多进程下管理端口
        $channel_server = new \Channel\Server('0.0.0.0', 2306);

        $this->startGateWay();
        $this->startBusinessWorker();
        $this->startRegister();

        Worker::runAll();
    }

    private function startBusinessWorker()
    {
        $worker                  = new BusinessWorker();
        $worker->name            = $this->serviceName . 'BusinessWorker';
        $worker->count           = 4;
        $worker->registerAddress = '127.0.0.1:1236';
        $worker->eventHandler    = config("workerman.{$this->serviceName}.eventHandler");
    }

    private function startGateWay()
    {
        $gateway = new Gateway("websocket://0.0.0.0:2346");
        $gateway->name                 = $this->serviceName . 'Gateway';
        $gateway->count                = 4;
        $gateway->lanIp                = '127.0.0.1';
        $gateway->startPort            = 2300;
        $gateway->pingInterval         = 30;
        $gateway->pingNotResponseLimit = 1;
        $gateway->pingData             = '{"type":"ping"}';
        $gateway->registerAddress      = '127.0.0.1:1236';
    }

    private function startRegister()
    {
        new Register('text://0.0.0.0:1236');
    }

}
