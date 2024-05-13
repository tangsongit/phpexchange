<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-28 15:28:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-04 18:06:03
 */

namespace App\Models;

use App\Events\HandDividendEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OptionSceneOrder extends Model
{
    //期权订单

    protected $table = 'option_scene_order';
    protected $primaryKey = 'order_id';
    protected $guarded = [];

    protected $casts = [
        'fee' => 'real',
        'bet_amount' => 'real',
        'odds' => 'real',
        'range' => 'real',
        'delivery_amount' => 'real',
        'delivery_time' => 'datetime'
    ];

    protected $attributes = [
        'status' => 1,
    ];

    public $appends = ['status_text', 'delivery_time_text', 'lottery_time'];

    const status_wait = 1;
    const status_delivered = 2;
    const status_cancel = 3;

    public static $statusMap = [
        self::status_wait => '待交割',
        self::status_delivered => '已交割',
        self::status_cancel => '流局',
    ];

    public function getStatusTextAttribute()
    {
        return self::$statusMap[$this->status];
    }

    public function getDeliveryTimeTextAttribute()
    {
        return blank($this->delivery_time) ? '--' : Carbon::createFromTimestamp($this->delivery_time)->toDateTimeString();
    }

    public function getLotteryTimeAttribute()
    {
        return ($lottery_time = $this->end_time - time()) > 0 ? $lottery_time : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function scene()
    {
        return $this->belongsTo(OptionScene::class, 'scene_id', 'scene_id');
    }

    public function bonus()
    {
        return $this->morphMany('App\Models\BonusLog', 'bonusable');
    }
}
