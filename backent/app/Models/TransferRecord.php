<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ApiException;

class TransferRecord  extends Model
{
    //划转记录

    protected $primaryKey = 'id';
    protected $table = 'user_transfer_record';
    protected $guarded = [];

    protected $casts = [
        'amount' => 'real',
    ];

    public static $statusMap = [
        1 => '划转成功',
        2 => '划转失败',
    ];
    
    public static $orderStatusMap = [
        0 => '未审核',
        1 => '划转成功',
        2 => '驳回',
    ];


    public static $accountMap = [
        'UserWallet' => '账户资产',
        'ContractAccount' => '合约账户',
        'OtcAccount' => '法币账户',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
    
     /**
     * @description: 审核通过
     * @process
     * 1、查询判断订单是否存在（是否为0）
     * 2、判断订单状态是否正常（未未处理）
     * 3、查询用户钱包是否存在（USDT）
     * 4、①将用户金额充值到USDT ②写入充值日志 ③更改订单状态未审核通过（1）
     * 5、返回True/false
     * @param {*}
     * @return {*}
     */
    public function agree($id)
    {
        // 查询订单是否存在
        $res =  $this->find($id);
        // 判断订单状态
        if ($res['order_status'] !== 0) {
            return false;
        }
        $uid = $res['user_id'];
        $amount = $res['amount'];
        $coin_name = $res['coin_name'];
        $userinfo = User::find($uid);
        
        // 开启事务
        DB::beginTransaction();
        try {
            
            DB::table('user_transfer_record')
                ->where('id', $id)
                ->update([
                    'order_status' => 1,
                ]);
            $user = User::query()->findOrFail($uid);
            $user->update_wallet_and_log($res['coin_id'], 'usable_balance', $amount, UserWallet::otc_account, 'fund_transfer');
            $user->update_wallet_and_log($res['coin_id'], 'freeze_balance', -$amount,  UserWallet::asset_account, 'fund_transfer');
            
            $content = "Your transfer order has been rejected. If you have any questions, please contact customer service in time";
            if($userinfo->email){
                sendEmailTransfer($userinfo->email,'emails.verify_transfer_remind_success');
            }
            
            if($userinfo->phone){
                //短信邮箱提醒用户
                $result = sendPhoneTransfer($userinfo->phone, $content);
            }
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiException($e->getMessage());
            return false;
        }
    }
    /**
     * @description: 拒绝审核
     * @param {*}
     * @return {*}
     */
    public function reject($id)
    {
        // 查询订单是否存在
        $res =  $this->find($id);
        // 判断订单状态
        if ($res['order_status'] !== 0) {
            return false;
        }
        $uid = $res['user_id'];
        $amount = $res['amount'];
        $coin_name = $res['coin_name'];
        $userinfo = User::find($uid);
        
        // 开启事务
        DB::beginTransaction();
        try {
            
            DB::table('user_transfer_record')
                ->where('id', $id)
                ->update([
                    'order_status' => 2,
                ]);
            $user = User::query()->findOrFail($uid);
            $user->update_wallet_and_log($res['coin_id'], 'usable_balance', $amount, UserWallet::asset_account, 'fund_transfer');
            $user->update_wallet_and_log($res['coin_id'], 'freeze_balance', -$amount,  UserWallet::asset_account, 'fund_transfer');
            
            
            $content = "Your transfer order has been rejected. If you have any questions, please contact customer service in time";
            if($userinfo->email){
                sendEmailTransfer($userinfo->email,'emails.verify_transfer_remind_error');
            }
            
            if($userinfo->phone){
                //短信邮箱提醒用户
                $result = sendPhoneTransfer($userinfo->phone, $content);
            }
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiException($e->getMessage());
            return false;
        }
    }
}
