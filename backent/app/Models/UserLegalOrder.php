<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserLegalOrder extends Model
{

    protected $table = 'user_legal_order';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'order_on', 'amount', 'number', 'unitPrice', 'currency', 'type', 'status', 'failure_time', 'pay_type','order_status','url','is_callback'];

    //状态
    const status_unpaid = 1; //代付款
    const status_wait = 2; //待放币
    const status_appeal = 3; //申诉中
    const status_success = 4; //交易完成
    const status_canceled = 5; // 已取消
    public static $statusMap = [
        self::status_unpaid => '代付款',
        self::status_wait => '待放币',
        self::status_appeal => '申诉中',
        self::status_success => '交易完成',
        self::status_canceled => ' 已取消',
    ];

    
    public static $statusOrderMap = [
        0 => '未审核',
        1 => '审核通过',
        2 => '审核拒绝',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
    
}
