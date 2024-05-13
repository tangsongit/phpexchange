<?php
/*
 * @Descripttion:
 * @version:
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:40:30
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWalletErrorLogs extends Model
{
    //用户意见反馈
    protected $primaryKey = 'id';
    /*表名称*/
    protected $table = 'user_wallet_error_logs';
    protected $guarded = [];


//    protected $appends = ['is_process_text'];

//    protected $attributes = [
//        'is_process' => 0,
//    ];

//    const STATUS_WAIT = 0;
//    const STATUS_PROCESSED = 1;
//
//    public static $statusMap = [
//        self::STATUS_WAIT => '未处理',
//        self::STATUS_PROCESSED => '已处理',
//    ];
//    public static $status = [
//        "0" => '未处理',
//        "1" => '已处理',
//    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

//    public function getIsProcessTextAttribute()
//    {
//        return self::$statusMap[$this->is_process];
//    }
//
//    public function getImgsAttribute($imgs)
//    {
//        $data = json_decode($imgs, true);
//        if (is_array($data)) {
//            $data = array_map(function ($value) {
//                return getFullPath($value);
//            }, $data);
//        }
//        return $data;
//    }
}
