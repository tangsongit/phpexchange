<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-17 20:50:18
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 21:04:57
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Dcat\Admin\Models\Administrator;

class ResetAdminAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '重置Admin账户';

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
            $this->error('当前处于生产环境，请勿操作!!');

            return;
        }
        $user = Administrator::where('username', 'admin')->first();
        if (empty($user)) {
            $user = new Administrator();
            $user->username = 'admin';
        }
        $user->password = bcrypt('admin');
        $user->name = 'Administrator';
        $user->save();
        $this->info('Admin账户已成功重置为 admin/admin');
        return 0;
    }
}
