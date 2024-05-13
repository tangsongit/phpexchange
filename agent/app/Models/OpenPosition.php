<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OpenPosition extends Model
{

    protected $table = 'option_scene_order';

    protected $primaryKey = 'order_id';

    const  direction_one = 1;
    const  direction_two= 2;
    const  direction_three = 3;
    public static $status = [
        self::direction_one => "涨（+）",
        self::direction_two => "跌（-）",
        self::direction_three=>"平（=）"
    ];

    const  status_one = 1;
    const  status_two= 2;
    public static $state = [
        self::status_one => "待交割",
        self::status_two => "已交割",
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','user_id');
    }

}
