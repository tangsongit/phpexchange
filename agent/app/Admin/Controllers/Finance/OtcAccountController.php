<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:43:22
 */

namespace App\Admin\Controllers\Finance;

use App\Models\Otc\OtcAccount;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Admin;


class OtcAccountController extends AdminController
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
        $user_id = Admin::user()->id;
        $base_ids = collect(get_childs($user_id))->pluck('user_id')->toArray();
        $base_ids[] = $user_id;
        $query = OtcAccount::with(['user', 'user_auth'])
            ->whereIn('user_id', $base_ids);
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->withBorder();
            $grid->disableActions();
            $grid->disableCreateButton();
            #统计
            $grid->header(function () use ($grid, $query) {
                $grid->model()->getQueries()->unique()->each(function ($v) use ($query) {
                    if (in_array($v['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'])) return;
                    call_user_func_array([$query, $v['method']], $v['arguments'] ?? []);
                });
                return $this->statistics($query);
            });

            // $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('user.username', '用户名');
            $grid->column('user_auth.realname', '姓名');
            $grid->column('coin_id');
            $grid->column('coin_name');
            $grid->column('usable_balance');
            $grid->column('freeze_balance');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id')->width(3);
                $filter->equal('user_id', '用户UID')->width(3);
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
    // protected function detail($id)
    // {
    //     return Show::make($id, new OtcAccount(), function (Show $show) {
    //         $show->field('id');
    //         $show->field('user_id');
    //         $show->field('coin_id');
    //         $show->field('coin_name');
    //         $show->field('usable_balance');
    //         $show->field('freeze_balance');
    //         $show->field('created_at');
    //         $show->field('updated_at');
    //     });
    // }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    // protected function form()
    // {
    //     return Form::make(new OtcAccount(), function (Form $form) {
    //         $form->display('id');
    //         $form->text('user_id');
    //         $form->text('coin_id');
    //         $form->text('coin_name');
    //         $form->text('usable_balance');
    //         $form->text('freeze_balance');

    //         $form->display('created_at');
    //         $form->display('updated_at');
    //     });
    // }
}
