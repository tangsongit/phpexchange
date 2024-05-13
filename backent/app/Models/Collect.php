<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:40:59
 */


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    protected  $table = "collect";
    protected $fillable = [
        "user_id", "pair_id", "pair_name"
    ];
}
