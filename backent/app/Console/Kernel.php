<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-14 10:05:14
 */

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
        /**
         * The Artisan commands provided by your application.
         *
         * @var array
         */
        protected $commands = [
                \App\Console\Commands\CreateOptionScene::class,
                \App\Console\Commands\CheckUserAuth::class,
                \App\Console\Commands\CancelScene::class,
                \App\Console\Commands\UpdateExchangeRate::class,
                \App\Console\Commands\DealRobot::class,
                \App\Console\Commands\ContractDealRobot::class,
                \App\Console\Commands\collection::class,
                \App\Console\Commands\FlatPosition::class,

                \App\Console\Commands\FakeKline::class,
        ];

        /**
         * Define the application's command schedule.
         *
         * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
         * @return void
         */
        protected function schedule(Schedule $schedule)
        {
                // $schedule->command('inspire')
                //          ->hourly();

                //创建期权场景 每分钟
                $schedule->command('createOptionScene')->everyMinute()->withoutOverlapping()->runInBackground();
                //用户认证系统自动审核通过
                //$schedule->command('checkUserAuth')->everyFiveMinutes()->withoutOverlapping()->runInBackground();
                // 异常期权场景处理
                $schedule->command('cancelScene')->everyFiveMinutes()->withoutOverlapping()->runInBackground();
                // Exchange委托取消
                $schedule->command('cancelBuyEntrust')->everyFiveMinutes()->withoutOverlapping()->runInBackground();
                $schedule->command('cancelSellEntrust')->everyFiveMinutes()->withoutOverlapping()->runInBackground();

                // 更新USD-CNY汇率
                $schedule->command('updateExchangeRate')->hourly()->withoutOverlapping()->runInBackground();
                // LVOK线
                $schedule->command('fakeKline')->dailyAt('23:00')->withoutOverlapping()->runInBackground();
                $schedule->command('fakeKline1')->dailyAt('23:00')->withoutOverlapping()->runInBackground();
                $schedule->command('fakeKline2')->dailyAt('23:00')->withoutOverlapping()->runInBackground();
                // 归集任务
                //        $schedule->command('collection')->everyMinute()->withoutOverlapping()->runInBackground();

                // erc20usdt充值扫描
                //        $schedule->command('ethtokentx')->everyTenMinutes()->withoutOverlapping()->runInBackground();
                // trc20usdt充值扫描
                //        $schedule->command('trxtokentx')->everyTenMinutes()->withoutOverlapping()->runInBackground();

                // 资金费收取
                // $schedule->command('capitalCost')->dailyAt('00:00')->withoutOverlapping()->runInBackground();
                // $schedule->command('capitalCost')->dailyAt('08:00')->withoutOverlapping()->runInBackground();
                // $schedule->command('capitalCost')->dailyAt('16:00')->withoutOverlapping()->runInBackground();

                // 申购活动
                $schedule->command('subscribe:settlement')->hourly()->withoutOverlapping()->runInBackground();

                // 期权每日返佣结算
                $schedule->command('Contract:SettleReward')->dailyAt('12:00')->withoutOverlapping()->runInBackground();
                // 代理业绩统计(按周)
                // $schedule->command('performance:statistics')->hourly()->withoutOverlapping()->runInBackground();

                // $schedule->command('check-otc-entrust')->everyMinute()->withoutOverlapping()->runInBackground();
                // $schedule->command('check-otc-order')->everyMinute()->withoutOverlapping()->runInBackground();
                // $schedule->command('auto-confirm-otc-order')->everyMinute()->withoutOverlapping()->runInBackground();
        }

        /**
         * Register the commands for the application.
         *
         * @return void
         */
        protected function commands()
        {
                $this->load(__DIR__ . '/Commands');

                require base_path('routes/console.php');
        }
}
