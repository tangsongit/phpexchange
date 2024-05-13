<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-13 11:03:55
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-18 18:20:40
 */

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;
use App\Models\User as Model;

class TeamList extends EloquentRepository
{

    protected $eloquentClass = Model::class;

    // public function getKeyName()
    // {
    //     return 'user_id';
    // }
    /**
     * 获取列表页面查询的字段.
     *
     * @return array
     */
    public function getGridColumns()
    {
        return [
            'user.user_id',
            'user.username',
            'user.referrer',
            'user.pid',
            'user.status',
            'user.trade_status',
            'user.is_agency',
            'user.is_place',
            'user.user_auth_level',
            'user.user_identity',
            'user.created_at',
            'wallet.usable_balance',
            'user.remark'
        ];
    }
}
