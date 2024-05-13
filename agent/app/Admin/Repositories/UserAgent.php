<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 14:15:05
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 14:32:03
 */

namespace App\Admin\Repositories;

use App\Models\AgentUser as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AgentUser extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
