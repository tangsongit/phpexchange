<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-06 18:27:41
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:44:10
 */
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-06 18:27:41
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 18:35:36
 */

namespace App\Console\Commands;

use App\Models\Contract\ContractRebate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutoSettleContractReward extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Contract:SettleReward';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '结算未完成的合约返佣';

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
        // 1、获取未结算订单
        // 2、结算订单
        // 2.1、更新结算状态
        // 2.2、结算佣金至代理商账户
        ContractRebate::getToBeSettleList()->each(function ($v) {
            $v->settle();
        });
    }
}
