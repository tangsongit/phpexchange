<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:40:41
 */

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{

    use Translatable;

    public $translationModel = BannerTranslations::class;
    public $translationForeignKey = 'b_id';
    public $translatedAttributes = ['imgurl'];

    protected $table = 'banner';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public static $locationTypeMap = [
        1 => '移动端轮播图',
        2 => 'PC端轮播图',
    ];

    public static $tourlTypeMap = [
        0 => '不跳转',
        1 => 'APP',
    ];
}
