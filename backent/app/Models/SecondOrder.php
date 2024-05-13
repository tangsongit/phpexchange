<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-23 11:57:39
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SecondOrder extends Model
{
    //public $timestamps = FALSE;
    protected $table = 'second_order';
    protected $fillable = ['close_status','result_status','control_status','close_price','profit'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    //InsideTradePair
    public function tradepair()
    {
        return $this->belongsTo(InsideTradePair::class, 'trade_pair_id', 'pair_id');
    }
    public function second()
    {
        return $this->belongsTo(SecondConfig::class, 'second_id', 'id');
    }

}
