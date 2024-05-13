<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-17 16:53:38
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-27 11:23:33
 */

namespace App\Admin\Controllers;

use App\Models\User;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use App\Admin\Renderable\UserTradeStatistics;
use App\Admin\Renderable\UserWalletExpand;

class UserTreeController extends AdminController
{
    public function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->column('user_id', '用户UID')->bold()->sortable();
            $grid->column('avatar', '头像')->image('', 50, 50);
            $grid->column('username', '用户名')->append(function () {
                $count = collect(User::getChilds($this->user_id))->count();
                return "（{$count}）";
            })->tree(true, false);
            $grid->column('phone', '电话');
            $grid->column('email', '邮箱地址');
            $grid->column('统计')->display('统计')->expand(UserTradeStatistics::make());
            $grid->column('资产')->display('资产')->expand(UserWalletExpand::make());
            $grid->column('identity', '身份')->display(function () {
                if ($this->is_agency == 1) $iden[] = '代理商';
                if ($this->is_place == 1) $iden[] = '渠道商';
                return $iden ?? [];
            })->label();

            $grid->created_at('注册时间');

            $grid->filter(function ($filter) {
                $filter->equal('user_id', '用户UID')->width(3);
                $filter->equal('phone', '电话')->width(3);
                $filter->like('username', '用户名')->width(3);
            });
        });
    }
}
