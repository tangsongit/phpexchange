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

class SecondUser extends Model
{
    public $timestamps = FALSE;
    protected $table = 'second_user';
    protected $fillable = ['user_id','result_status'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
