<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-17 18:23:19
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-28 17:45:06
 */


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Dcat\Admin\Traits\ModelTree;

class Place extends Model
{
    use ModelTree;
    protected $table = "users";
    protected $primaryKey = 'user_id';


    protected $titleColumn = 'username';
    protected $parentColumn = 'pid';
    // 只获取代理列表
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('is_place', function (Builder $builder) {
            $builder->where('is_place', '=', 1);
        });
    }

    public function getOrderColumn()
    {
        return null;
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
    public function getStatusTextAttribute()
    {
        return self::$userStatusMap[$this->status];
    }

    //用户状态
    const user_status_freeze = 0; //冻结
    const user_status_normal = 1; //正常
    public static $userStatusMap = [
        self::user_status_freeze => '冻结',
        self::user_status_normal => '正常',
    ];

    const agent_code0 = 0;
    const agent_code1 = 1;
    const agent_code2 = 2;
    const agent_code3 = 3;
    const agent_code4 = 4;
    const agent_code5 = 5;

    public static $grade = [
        self::agent_code0 => '超级管理员',
        self::agent_code1 => 'A1',
        self::agent_code2 => "A2",
        self::agent_code3 => "A3",
        self::agent_code4 => "A4",
        self::agent_code5 => "A5",
    ];

    const agent_zero = 0;
    const agent_one = 1;
    static $type = [
        self::agent_zero => "用户",
        self::agent_one => "代理"
    ];


    /**
     * @description: 获取下级代理
     * @param {*}
     * @return {*}
     */
    public static function getChildPlaceList($user_id)
    {
        return self::query()
            ->where('pid', $user_id)
            ->pluck('user_id')
            ->toArray();
    }


    public function agentuser()
    {
        return $this->hasOne(AgentUser::class, 'id', 'user_id');
    }
}
