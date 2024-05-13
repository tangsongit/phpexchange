<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:45:14
 */

namespace App\Models\Mongodb;

use Jenssegers\Mongodb\Eloquent\Model;

class NewPriceBook extends Model
{
    // 最新价格集合

    protected $connection = 'mongodb';          //库名
    protected $collection = 'newPriceBook';     //文档名
    protected $primaryKey = 'id';               //设置id
    protected $guarded = [];

    //    public $timestamps = false;

}
