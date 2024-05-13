<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/1
 * Time: 10:30
 */

namespace App\Http\Controllers\Api\V1;

use App\Models\Coins;
use App\Models\TransferRecord;
use App\Models\UserWallet;
use App\Models\UserWalletLog;
use App\Services\UserService;
use App\Services\UserWalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\AdminSetting;
use App\Models\User;
use App\Models\UserLegalOrder;

class UserLegalController extends ApiController
{
    public $private_key = "-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDa3p8F2vREDJ8X9aDIBmxgbJWIPCx9nQGSRloyQmQy2GKgAHEA
ct4uAdJsAN7+l61jpVfcp8fhRQtZgPtKW6bEM4mFUIpeDJy+twAeQi5e1hQTK4vM
f10UacNMOoPVt6nhQ564afsLSiAx2JIg/ngDzJMxgbIjPxk3CIy/5PvwKwIDAQAB
AoGBAJIIPZQ7jgUlYrUqxzcOyhrf+Dlo5Mp/CoBdfmrQT2h5ZfyZrsv82G9b+djk
D+VQsHiu5luserm8RqFWZNQtKKu+U4lVFY5giySzQPE0mN8rXyDitwZ4rs2yBOCk
uCVdAQTqxZxGbtxl7cPdLdUznClJdRvOSe6N8qNPUsWnxV5xAkEA7UdJaWUAa1ll
RYSKs94ZQAY/fQsEUm0Zhelu/4eeaohE4cvSD5rwGszF57W+nQ0Ia/wBjmXUJhtR
p8SKxHOhCQJBAOwjf/U6CQmfWf3FPy73dFg8CnUTpCGMfgC0XLhy0m1hq9zXa1IA
r0CefsTvsLMUjW6Rnj2427k7/kWKYlIYuJMCQE2oHB2zYbzAiEWFSIPvt6HdqZ+6
IFL9w/Gw4ZQeBbnmGW0w8PIMinKq/EaGk/kAj/YPh07cgt9p54KZ77S2B0kCQQCE
wQBy8Qmbq0aAcJ+w29VAtaB7aWtgoQdFhiCKYaMDc2GXalQfadsczP4f4VDJnMhW
XO9Fa+O7I4sztTTJSrSZAkB0epyYn51w7zVdZJcbHh46qrQlC0KjFNG26Sqc/T5l
oPyGUw1SEHms9w5ZwzY8oXSi3SngSVRahmo+phw9BWnj
-----END RSA PRIVATE KEY-----";
    
    
    public $public_key = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDa3p8F2vREDJ8X9aDIBmxgbJWI
PCx9nQGSRloyQmQy2GKgAHEAct4uAdJsAN7+l61jpVfcp8fhRQtZgPtKW6bEM4mF
UIpeDJy+twAeQi5e1hQTK4vMf10UacNMOoPVt6nhQ564afsLSiAx2JIg/ngDzJMx
gbIjPxk3CIy/5PvwKwIDAQAB
-----END PUBLIC KEY-----
";
        
        
    public $firmIdentity = 'BINVET';
    public $key_len = 0;

    public $currency = array(
        'USDT'=>1,
        'USDB'=>2,
        'BTC'=>3,
        'ETH'=>4,
        'EOS'=>5,
        'BCH'=>6,
        'LTC'=>7,
        'TUSD'=>8,
        'PAX'=>9
        );
    
    
    //发币买和卖接口
    public function buy_sell(Request $request){
        $user = $this->current_user();
        
        if ($vr = $this->verifyField($request->all(), [
            'currency' => 'required|string',
            'amount' => 'required',
            'number' => 'required',
            'unitPrice' => 'required',
            'type' => 'required|string',
        ])) return $vr;
        
        try {
            $params = $request->post();
            $currency = $params["currency"];
            $type = $params["type"];
            $pay_type = $params["pay_type"];
            
            // 内容
            $orederNum = $this->firmIdentity .$currency . date('YmdHis') . rand(1000, 9999);
            $t = time();
            
            
            //获取用户认证号
            $user_auth = Db::table('user_auth')->where(['user_id'=>$user['user_id']])->first();
            $content = [
                "orderNum"     => $orederNum,
                "firmIdentity" => $this->firmIdentity,
                "userIdentity" => $user_auth->id_card,
                "name"  => $user_auth->realname,
                "token" => $currency,
                "bt"    => $t
            ];
            
            //购买类型：0币数量，1人民币
            if($pay_type == 1){
                $content["amount"] = $params["amount"];
                $params["number"]  = floatval(bcdiv($params["amount"],$params["unitPrice"],6));
            }else{
                
                $content["number"] = $params["number"];
                $params["amount"]  = floatval(bcmul($params["number"],$params["unitPrice"],6));
            }
            
            if($params["amount"] < 100){
                return $this->error('error','交易金额<100CNY');
            }
            
            $content['legal'] = 'CNY';
            
            //如果是卖币先冻结用户金额
            if($type == 'sell'){
                $user_wallet = \App\Models\UserWallet::where(['user_id'=>$user['user_id'],'coin_name'=>strtoupper($currency)])->first();
                // echo $user_wallet->usable_balance .'<'. $params["number"];die;
                if($user_wallet && $user_wallet->usable_balance < $params["number"]){
                    return $this->error('error','资金账户币种余额不足');
                }
                
               //冻结用户余额
                $user->update_wallet_and_log($otc_account['coin_id'], 'freeze_balance', $params["number"], UserWallet::otc_account, 'legal_transaction');
                $user->update_wallet_and_log($otc_account['coin_id'], 'usable_balance', -$params["number"], UserWallet::otc_account, 'legal_transaction');
            
            }
           
            
            //创建订单
            \App\Models\UserLegalOrder::create([
                'user_id'  => $user['user_id'],
                'order_on' => $orederNum,
                'amount'   => $params["amount"],
                'number'   => $params["number"],
                'unitPrice'=> $params['unitPrice'],
                'currency' => $currency,
                'type'     => $type,
                'pay_type'     => !empty($pay_type) ? $pay_type : 0,
                'failure_time' => time() + 960  //失效时间
            ]);
                
            
            
            
            ksort($content);
            $p = $result = [];
            foreach ($content as $k => $v) {
                $p[] = $k . '=' . $v;
                $result[] = $k . $v;
            }
            $str = implode("", $result);
           
            $rsa = new XRsa($this->public_key, $this->private_key);
           
            $sign = $rsa->privateEncrypt($str);
            $url = "https://ct.biya88.com/" . $type . "/home?sign=" . $sign . '&' . implode("&", $p);
            return $this->success('ok',$url);
        } catch (\Exception $e) {
            return $this->error('error',$e->getMessage());
        }
    }
    
    
    /**
     * 法币订单状态查看
     * 
     */ 
    public function order_status(Request $request){
        
        $post_data['ordernum'] = $request->input('order_on');
        $post_data['bt'] = time();
        $post_data['firmIdentity'] = $this->firmIdentity;
        
        // $url = 'http://113.31.126.66:8015/foreign/v1/order/inquiry'; // 测试
        $url = 'https://api-trading.biya.in/foreign/v1/order/inquiry'; // 正式
        
        ksort($post_data);
        $p = $result = [];
        foreach ($post_data as $k => $v) {
            $p[] = $k . '=' . $v;
            $result[] = $k . $v;
        }
        $str = implode("", $result);
       
        $rsa = new XRsa($this->public_key, $this->private_key);
       
        $post_data['sign'] = $rsa->privateEncrypt($str);
            
            
        
        $result = $this->post_curl($url,$post_data);
        
        $result = json_decode($result,true);
        if($result['code'] == 0){
            return $this->success('ok',$result['data']);
        }
        
        return $this->error('error');
        
    }
    
    
    /**
     * 币种价格 buy买  sell卖
     * 
     */ 
    public function unit_price(Request $request){
        
        $post_data['currency'] = $request->input('coin_name');
        $post_data['type'] = $request->input('type');
        $post_data['identity'] = $this->firmIdentity;
        
        // $url = 'http://113.31.126.66:8015/foreign/v1/refer/in/price'; // 测试
        $url = 'https://api-trading.biya.in/foreign/v1/refer/in/price'; // 正式
        
        
        $result = $this->post_curl($url,$post_data);
        $result = json_decode($result,true);
        if($result['code'] == 0){
            return $this->success('ok',['price'=>$result['data']['price']]);
        }
        return $this->success('ok',['price'=>6.41]);
        
    }
    
    
    
    //异步回调
    public function callback(Request $request){
        $postdata = $request->all();
        
        $rsa = new XRsa($this->public_key, $this->private_key);
        $sign = $rsa->privateDecrypt($postdata['sign']);
        $msg  = $postdata['msg'];
        info('=====收到法币回调通知======',$postdata);
        file_put_contents('callback.log',date('Y-m-d H:i:s',time()) . var_export($postdata,true) ." \n",FILE_APPEND);
        unset($postdata['stateCode']);
        unset($postdata['msg']);
        unset($postdata['sign']);
        ksort($postdata);
        $p = $result = [];
        foreach ($postdata as $k => $v) {
            $p[] = $k . '=' . $v;
            $result[] = $k . $v;
        }
        $str = implode("", $result);
       
        //签名认证
        if($sign != $str){
            info('=====法币交易回调通知验签失败======',$request->all());
            return $this->error('签名错误');
        }
        
        
        DB::beginTransaction();
        try{
            $orderNumber = $postdata['orderNumber'];
            //判断订单是否存在
            $order_info = \App\Models\UserLegalOrder::where(['order_on'=>$orderNumber])->first();
            
           
           
           
            $update = [
                    'status' => $postdata['orderStatus'],
                    'remarks' => $msg,
                    'is_callback' =>1
                ];
            if($order_info['is_callback'] != 2){
                
                //获取用户钱包
                $user_wallet = \App\Models\OtcAccount::query()->where(['coin_name'=>$postdata['token'],'user_id' => $order_info['user_id']])->first();
                $user = User::query()->findOrFail($order_info['user_id']);

                if($postdata['type'] == 'buy'){ //买订单
                    if($postdata['orderStatus'] == 4){
                         // 更新用户余额
                        $user->update_wallet_and_log($user_wallet['coin_id'],'usable_balance',$postdata['number'],UserWallet::otc_account,'legal_transaction');
                        $update['is_callback'] = 2;
                    }
                    
                }elseif($postdata['type'] == 'sell'){ //卖的订单
                    if($postdata['orderStatus'] == 4){
                        // 更新扣除用户冻结余额
                        $user->update_wallet_and_log($user_wallet['coin_id'],'freeze_balance',-$postdata["number"],UserWallet::otc_account,'legal_transaction');
                        $update['is_callback'] = 2;
                    }elseif($postdata['orderStatus'] == 5){
                        //订单取消，扣除冻结余额，增加正常资产
                        $user->update_wallet_and_log($user_wallet['coin_id'],'freeze_balance',-$postdata["number"],UserWallet::otc_account,'legal_transaction');
                        $user->update_wallet_and_log($user_wallet['coin_id'],'usable_balance',$postdata["number"],UserWallet::otc_account,'legal_transaction');
    
                    }
                }
                //变更订单
                \App\Models\UserLegalOrder::where(['id'=>$order_info['id']])->update($update);
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            info('=====法币交易回调失败======',$e->getMessage());
            return $this->error('error',$e->getMessage());
        }
        
        return $this->success('ok');
    }
    
    
    
    //CURL
    private function post_curl($url,$postdata=[])
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
        
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_TIMEOUT,60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
        ]);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return $output;
    }

}
