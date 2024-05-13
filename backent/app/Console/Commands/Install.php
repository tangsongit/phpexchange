<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-17 20:29:51
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 21:04:48
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:Install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '对交易所程序进行初始化安装';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!config('app.debug')) {
            $this->error('当前处于生产环境，请勿操作!');

            return;
        }
        $this->info('正在优化配置！');
        $this->call('optimize:clear');
        $this->info('正在设置存储系统！');
        $this->call('storage:link');
        $this->info('正在配置APP密钥！');
        $this->call('key:generate');
        //        $this->info('正在配置JWT密钥！');
        //        $this->call('jwt:secret');
        $this->info('正在处理数据库迁移！');
        $this->call('migrate');
        $this->info('正在初始化数据！');
        $this->call('db:seed', ['--class' => 'InitDatabaseSeeder']);
        $this->call('exchange:reset');
        $this->info('正在处理清理模版缓存！');
        $this->call('view:clear');
        $this->info('安装完成！');
        $this->warn('用户名密码都为：admin');
        return 0;
    }
}
