<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Agent extends Model
{
    protected $table = "users";
    protected $primaryKey = 'user_id';

    // 只获取代理列表
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('is_agency', function (Builder $builder) {
            $builder->where('is_agency', '=', 1);
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

    //获取最下级基础代理IDS
    public static function getBaseAgentIds($id, $deep = 4)
    {
        $items = self::query()->where('is_agency', 1)->select('id', 'pid', 'deep')->get();
        if (blank($items)) return [];

        // $agent = $items->where('id',$id)->first();
        // return [$id];
        // if($agent['deep'] == 4) return [$id];

        $items = $items->toArray();

        $subIds = get_agent_child($items, $id);
        $subIds[] = $id;

        return $subIds;
    }

    public static function getBaseAgentIdssss($id, $deep = 4)
    {
        $items = self::query()->where('is_agency', 1)->select('id', 'pid', 'deep')->get();
        if (blank($items)) return [];

        $agent = $items->where('id', $id)->first();
        //return [$id];
        //if($agent['deep'] == 4) return [$id];

        $items = $items->toArray();
        //print_r($items);
        //echo $id;
        $subIds = get_agent_child($items, $id, $deep);
        $subIds[] = $id;
        //print_r($subIds);
        return $subIds;
    }

    //获取所有代理IDS
    public static function getAgentIds($id)
    {
        $items = self::query()->where('is_agency', 1)->select('id', 'pid', 'deep')->get();

        if (blank($items)) {
            return [];
        } else {
            $items = $items->toArray();
        }

        $subIds = get_agent_child($items, $id);

        return $subIds;
    }

    /**
     * @description: 获取下级代理
     * @param {*}
     * @return {*}
     */
    public static function getChildAgentList($user_id)
    {
        return self::query()
            ->where('pid', $user_id)
            ->pluck('user_id')
            ->toArray();
    }

    static function judge($deep)
    {

        if (!in_array($deep, self::$grade)) return false;

        $arr = array();
        foreach (self::$grade as $k => $value) {
            if ($k < $deep) continue;

            $arr[] = $value;
        }
        return $arr;
    }

    #代理等级上限
    static function astrict($green)
    {
        if ($green >= 10) {
            return false;
        }
        return true;
    }

    public function AgentUser()
    {
        return $this->hasOne(AgentUser::class, 'id', 'user_id');
    }
}
