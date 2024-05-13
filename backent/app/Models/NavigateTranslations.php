<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:41:28
 */


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class NavigateTranslations extends Model
{
    protected $table = 'navigation_translations';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['locale', 'name'];
}
