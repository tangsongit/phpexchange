<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:42:12
 */

namespace App\Providers;

use App\Models\ContractPosition;
use App\Models\InsideTradeOrder;
use App\Models\TestTradeOrder;
use App\Observers\ContractPositionObserver;
use App\Observers\InsideTradeOrderObserver;
use App\Observers\TestTradeOrderObserver;
use Illuminate\Support\ServiceProvider;
use App\Pool\Core\CoRedis;
use App\Pool\Redis\RedisPool;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //注册Redis 连接池
        $this->app->singleton('redis', function () {
            return new CoRedis(new RedisPool($this->app));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app('api.exception')->register(function (\Exception $exception) {
            $request = \Illuminate\Http\Request::capture();
            return app('App\Exceptions\Handler')->render($request, $exception);
        });

        InsideTradeOrder::observe(InsideTradeOrderObserver::class);
        ContractPosition::observe(ContractPositionObserver::class);
        //        TestTradeOrder::observe(TestTradeOrderObserver::class);
    }
}
