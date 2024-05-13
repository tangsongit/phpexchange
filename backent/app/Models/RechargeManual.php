<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-14 11:26:05
 */
/*
 * @Author: your name
 * @Date: 2021-06-03 11:56:59
 * @LastEditTime: 2021-08-09 17:41:41
 * @LastEditors: GuaPi
 * @Description: In User Settings Edit
 * @FilePath: \server\app\Models\RechargeManual.php
 */

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserWallet;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ApiException;

use function PHPSTORM_META\map;

class RechargeManual extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'recharge_manual';
    protected $primaryKey = 'id';


    /**
     * @description: 模型属性的默认值 
     * @param {*}
     * @return {*}
     */
    protected $attributes = [];

    /**
     * @description: 同意充值
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
        if ($res['status'] !== 0) {
            return false;
        }
        $uid = $res['uid'];
        $num = $res['num'];
        $user = User::find($uid);
        // 开启事务
        DB::beginTransaction();
        try {
            $user->update_wallet_and_log(1, 'usable_balance', $num, UserWallet::asset_account, 'recharge', '手动充值');
            DB::table('user_wallet_recharge')
                ->insert([
                    'user_id' => $uid,
                    'username' => $user->username,
                    'coin_id' => 1,
                    'coin_name' => 'USDT',
                    'datetime' => time(),
                    'amount' => $num,
                    'status' => 1,
                    'type' => 1,
                    'account_type' => 1,
                    'note' => '手动上分'
                ]);
            DB::table('recharge_manual')
                ->where('id', $id)
                ->update([
                    'id' => $id,
                    'status' => 1
                ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiException($e->getMessage());
            return false;
        }
    }
    /**
     * @description: 拒绝充值
     * @param {*}
     * @return {*}
     */
    public function reject($id)
    {
        // 更改手动充值状态
        $q1 = DB::table('recharge_manual')
            ->where('id', $id)
            ->update(['status' => 2]);
        if (!$q1) {
            return false;
        }
        return true;
    }
    // 关联表
    public function user()
    {
        return $this->belongsTo(User::class, 'uid', 'user_id');
    }
}
