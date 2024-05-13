<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncAddress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sync_address';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function check($coin_name)
    {
        $lock_file = storage_path("load{$coin_name}.lock");
        if (!flock($this->fp = fopen($lock_file, 'w'), LOCK_NB | LOCK_EX)) {
            //无法取得锁就退出
            die('cannot get lock，already running?');
        }
        register_shutdown_function('unlink', $lock_file);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->check("command_sync_address");
        $coin = DB::table("coins")->where("coin_name", "USDT")->first();
        DB::table('users')->orderBy('user_id','desc')
            ->whereNotIn('user_id', function ($query) use ($coin) {
                $query->select('user_id')
                    ->from('address_deposit')
                    ->where("address_deposit.coin_id", $coin->coin_id)
                    ->where("address_deposit.type", 2);
            })->chunk(100, function ($users) use ($coin) {
                foreach ($users as $user) {
                    $url = 'http://ec2-35-168-20-64.compute-1.amazonaws.com:8083/proto/address';
                    $post_data=[];
                    $post_data['appKey']=$coin->appKey;
                    //用户id
                    $post_data['customerNo']=$user->user_id;

                    $post_data['reqTime']=time();
                    $post_data['symbol']=$coin->coin_name;
                    $sign='';
                    foreach ($post_data as $key=>$val){
                        $sign=$sign.$key."=".$val."&";
                    }
                    $sign=$sign."appSecret=".$coin->appSecret;
                    $post_data['sign']=md5($sign);
                    $data = self::curlPost($url,$post_data);
                    $data = json_decode($data,true);
                    if($data['code']!=0){
                        continue;
                    }
                    DB::beginTransaction();
                    $LockAddress = DB::table("address_deposit")->where("coin_id", $coin->coin_id)->where("user_id", $user->id)->where('type',2)->first();
                    if ($LockAddress) {
                        //地址存在
                        DB::rollBack();
                        return;
                    }
                    $address = $data['data']['address'];
                    if ($address == false) {
                        DB::rollBack();
                        return;
                    }
                    DB::table("address_deposit")->insert([
                        "coin_id" => $coin->coin_id,
                        "user_id" => $user->user_id,
                        "address" => $address,
                        "type"    => 2
                    ]);
                    DB::commit();
                }
            });
    }

    /**
     * 通过CURL发送HTTP请求
     * @param string $url //请求URL
     * @param array $postFields //请求参数
     * @return mixed
     */
    private function curlPost($url, $postFields)
    {
        $postFields = http_build_query($postFields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT,60);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
