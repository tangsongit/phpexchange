<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-09-01 11:51:09
 */

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/29
 * Time: 19:11
 */

namespace App\Admin\Controllers;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\Coins;
use App\Models\User;
use App\Models\UserWallet;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

class UserAssetsController extends AdminController
{

    public function statistics($query)
    {
        global $con;
        $query->get(['coin_name', 'usable_balance', 'freeze_balance'])
            ->groupBy('coin_name')
            ->each(function ($v, $k) {
                // 资产 = 可用资产 + 冻结资产
                global $con;
                $con .= "<code>{$k}资产：" . ($v->sum('usable_balance') + $v->sum('freeze_balance')) . '</code>&nbsp;';
            });
        return Alert::make($con, '统计')->info();
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $query = UserWallet::with(['user']);
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->model()->orderByDesc('user_id');

            #统计
            $grid->header(function () use ($grid, $query) {
                $grid->model()->getQueries()->unique()->each(function ($v) use ($query) {
                    if (in_array($v['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'])) return;
                    call_user_func_array([$query, $v['method']], $v['arguments'] ?? []);
                });
                return $this->statistics($query);
            });

            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableRowSelector();

            $grid->column('user_id', 'UID');
            $grid->column('user.username', '用户名');
            $grid->coin_name;
            $grid->usable_balance->display(function ($v) {
                return custom_number_format($v, 8);
            })->sortable();
            $grid->freeze_balance->display(function ($v) {
                return custom_number_format($v, 8);
            })->sortable();
            
            $grid->column('otcWallet.usable_balance', '法币可用余额');
            $grid->column('otcWallet.freeze_balance', '法币冻结余额');
            $grid->disableCreateButton();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('user_id', '会员ID')->width(2);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(3);
                $filter->where('agent_id', function ($query) {
                    $referrer = $this->input;
                    $childs = collect(get_childs($referrer))->pluck('user_id')->toArray();
                    $query->whereIn('user_id', $childs);
                }, '链上查询')->placeholder('代理商UID')->width(3);
                $filter->like('coin_name', '币种名字')->width(3);
                $filter->between('created_at', "时间")->datetime()->width(4);
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new UserWallet(), function (Show $show) {
            // 这里的字段会自动使用翻译文件
            $show->id;
            $show->coin_name;
            $show->address;
            $show->usable_balance;
            $show->freeze_balance;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new UserWallet(), function (Form $form) {
            // 这里的字段会自动使用翻译文件
            $form->display('id');
            $form->text('coin_name');
            $form->text('usable_balance');
            $form->text('freeze_balance');


            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
