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

class KuangjCycle extends Model
{
    //
    protected $table = 'kuangji_cycle';

    protected $appends = ['coin_name'];
    
   
    
    public function getCoinNameAttribute(){
     return $this->hasOne(Coins::class, 'coin_id', 'coin_id')->value('coin_name');
    }
    public function coins(){
        return $this->belongsTo(Coins::class,'coin_id','coin_id');
    }
    
    public function coink(){
        return $this->belongsTo(Coins::class,'coink_id','coin_id');
    }

}