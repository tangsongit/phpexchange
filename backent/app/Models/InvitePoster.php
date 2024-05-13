<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-11 17:04:47
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-11 17:51:06
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitePoster extends Model
{
    protected $table = 'invite_poster';

    protected $appends = ['image_url'];

    function getImageUrlAttribute($value)
    {
        return  getFullPath($this->image);
    }
}
