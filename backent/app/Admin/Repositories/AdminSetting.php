<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:43:55
 */

namespace App\Admin\Repositories;

use App\Models\Admin\AdminSetting as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AdminSetting extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
