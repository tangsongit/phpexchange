<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-05 10:13:35
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:40:36
 */
/*
 * @Descripttion: 代理商/渠道商后台用户表
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 14:15:05
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 17:49:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentUser extends Model
{


    protected $table = 'agent_users';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $hidden = ['password'];


    //代理状态
    const user_status_freeze = 0; //冻结
    const user_status_normal = 1; //正常
    public static $userStatusMap = [
        self::user_status_freeze => '未激活',
        self::user_status_normal => '正常',
    ];
    protected $attributes = ['remember_token'=>'K9VXOVFPHUT37YU5'];
    /**
     * @description: 查看代理用户名是否已经存在
     * @param {*} $username 用户名
     * @param {*} $user_id 排除用户ID
     * @return {*}
     */
    public static function isUsernameExist($username, $user_id = null)
    {
        $baseQuery = self::query()->where('username', $username);
        if ($user_id) {
            $baseQuery = $baseQuery->where('id', '<>', $user_id);
        }
        return blank($baseQuery->first()) ? false : true;
    }
    // 使用修改器转换百分比
    // 默认分佣比例  
    public function getRebateRateAttribute($value)
    {
        return is_null($value) ? null : $value * 100;
    }
    public function setRebateRateAttribute($value)
    {
        $this->attributes['rebate_rate'] = is_null($value) ? null : $value / 100;
    }
    // 币币交易分佣比例  
    public function getRebateRateExchangeAttribute($value)
    {
        return is_null($value) ? null : $value * 100;
    }
    public function setRebateRateExchangeAttribute($value)
    {
        $this->attributes['rebate_rate_exchange'] = is_null($value) ? null : $value / 100;
    }
    // 申购分佣比例  
    public function getRebateRateSubscribeAttribute($value)
    {
        return is_null($value) ? null : $value * 100;
    }
    public function setRebateRateSubscribeAttribute($value)
    {
        $this->attributes['rebate_rate_subscribe'] = is_null($value) ? null : $value / 100;
    }
    // 默认分佣比例  
    public function getRebateRateContractAttribute($value)
    {
        return is_null($value) ? null : $value * 100;
    }
    public function setRebateRateContractAttribute($value)
    {
        $this->attributes['rebate_rate_contract'] = is_null($value) ? null : $value / 100;
    }
    // 默认分佣比例  
    public function getRebateRateOptionAttribute($value)
    {
        return is_null($value) ? null : $value * 100;
    }
    public function setRebateRateOPtionAttribute($value)
    {
        $this->attributes['rebate_rate_option'] = is_null($value) ? null : $value / 100;
    }

    // 密码修改器
    public function setPasswordAttribute($v)
    {
        $this->attributes['password'] = bcrypt($v);
    }

    // 关联用户表
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
