<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:40:32
 */

namespace App\Models;


use Astrotomic\Translatable\Translatable;
use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;


class AdvicesCategory extends Model
{
    use ModelTree, Translatable;

    public $translationModel = adviceCategoryTranslations::class;
    public $translationForeignKey = 'category_id';
    public $translatedAttributes = ['name'];
    protected $table = 'advices_category';
    public $timestamps = false;
}
