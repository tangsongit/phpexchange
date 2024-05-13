<?php
/*
 * @Descripttion: 代理信息
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 14:15:05
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-23 16:44:10
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentUser extends Model
{

    protected $table = 'agent_users';

    protected $guarded = [];
    protected $hidden = ['password'];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }


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
            $baseQuery = $baseQuery->where('user_id', '<>', $user_id);
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

    // 获取代理商/渠道商身份
}
