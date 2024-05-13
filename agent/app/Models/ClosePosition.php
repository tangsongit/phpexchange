<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ClosePosition extends Model
{

    protected $table = 'option_scene_order';

    protected $primaryKey = 'order_id';

    const  direction_one = 1;
    const  direction_two= 2;
    const  direction_three = 3;
    public static $direction = [
        self::direction_one => "涨（+）",
        self::direction_two => "跌（-）",
        self::direction_three=>"平（=）"
    ];


    const  wait_for= 1;#等待交割
    const  history = 2;#历史交割
    const  run_down = 3;#流局
    public static $status = [
        self::wait_for => "等待交割",
        self::history => "历史交割",
        self::run_down=>"流局"
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','user_id');
    }

}
