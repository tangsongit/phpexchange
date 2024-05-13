<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-04 22:26:37
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:41:39
 */
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-04 22:26:37
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 18:22:23
 */


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Scopes\AgentScope;
use Illuminate\Database\Eloquent\Builder;

class Place extends Model
{
    protected $table = "users";
    protected $primaryKey = 'user_id';
    protected $guarded = [];

    // 只获取代理列表
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('is_place', function (Builder $builder) {
            $builder->where('is_place', 1);
        });
    }

    //用户认证
    const user_auth_level_wait = 0;
    const user_auth_level_primary = 1;
    const user_auth_level_top = 2;
    public static $userAuthMap = [
        self::user_auth_level_wait => '未认证',
        self::user_auth_level_primary => '初级认证',
        self::user_auth_level_top => '高级认证',
    ];
    /* public function getStatusTextAttribute()
    {
        return self::$userStatusMap[$this->status];
    }*/

    //用户状态
    const user_status_freeze = 0; //冻结
    const user_status_normal = 1; //正常
    public static $userStatusMap = [
        self::user_status_freeze => '未激活',
        self::user_status_normal => '正常',
    ];


    // 关联代理信息表
    public function agent_user()
    {
        return $this->hasOne(AgentUser::class, 'id', 'user_id');
    }
}
