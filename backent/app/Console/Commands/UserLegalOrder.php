<?php

namespace App\Console\Commands;

use App\Models\OtcAccount;
use App\Models\UserWallet;
use App\Models\User;
use App\Models\UserLegalOrder as UserLegalOrderModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class UserLegalOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UserLegalOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '法币订单超时处理';

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
        while (true) {
          
            $buy_orders = UserLegalOrderModels::query()->whereIn('is_callback',[0])->where('status',1)->where('failure_time', '<', time())->get();
            
            if ($buy_orders) {
                $buy_orders = $buy_orders->toArray();
                foreach ($buy_orders as $k=>$v){
                    
                    DB::beginTransaction();
                    try {
                        //更新订单
                        
                        $i = UserLegalOrderModels::query()->where('id',$v['id'])->update(['status'=>5,'remarks'=>'订单自动失效','updated_at'=>date('Y-m-d H:i:s',time())]);
                        
                        //更新用户余额
                        $user_wallet = OtcAccount::query()->where(['user_id'=>$v['user_id'],'coin_name'=>$v['currency']])->first();
                       
                        if($v['type'] == 'sell'){
                            
                            $user = User::query()->findOrFail($v['user_id']);
                            
                            //订单取消，扣除冻结余额，增加正常资产
                            $user->update_wallet_and_log($user_wallet['coin_id'],'freeze_balance',-$v["number"],UserWallet::otc_account,'legal_transaction');
                            $user->update_wallet_and_log($user_wallet['coin_id'],'usable_balance',$v["number"],UserWallet::otc_account,'legal_transaction');
                        
                        }
                        
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        info('=====自动取消失效ERROR======'. $e->getMessage());
                    }
                    
                }
            }
            sleep(2);
        }
    }
}
