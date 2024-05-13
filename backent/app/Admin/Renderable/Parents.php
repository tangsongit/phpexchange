<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-16 18:34:52
 */


namespace App\Admin\Renderable;


use App\Models\UserWallet;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Support\LazyRenderable;
use App\Admin\Metrics\User as UserCard;
use App\Models\User;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Table;

class Parents extends LazyRenderable
{

    public function render()
    {
        $id = $this->key;

        $data = User::getParentUsers($id)->map(function ($v) {
            return [
                'user_id' => $v->user_id,
                'username' => $v->username,
            ];
        })->toArray();

        $titles = [
            'UID',
            '用户名',
        ];

        return Table::make($titles, $data);
    }
}
