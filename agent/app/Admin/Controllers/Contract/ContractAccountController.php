<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-28 15:28:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-09-09 17:38:38
 */

namespace App\Admin\Controllers\Contract;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\SustainableAccount;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\User;
use Dcat\Admin\Widgets\Alert;

class ContractAccountController extends AdminController
{
    protected function statistics($query)
    {
        // 统计 总资产 持仓保证金  委托冻结
        $base_data = $query->get(['margin_name', 'usable_balance', 'used_balance', 'freeze_balance']);

        $usable_balance = $base_data->sum('usable_balance');
        $used_balance = $base_data->sum('used_balance');
        $freeze_balance = $base_data->sum('freeze_balance');

        $con = "<code>可用保证金：{$usable_balance} </code>";
        $con .= "<code>持仓保证金：{$used_balance} </code>";
        $con .= "<code>委托冻结：{$freeze_balance} </code>";
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
        $base_ids = collect(User::getChilds($user_id))->pluck('user_id')->toArray();
        $base_ids[] = $user_id;
        $query = SustainableAccount::with('user')
            ->whereIn('user_id', $base_ids);
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->model()->orderByDesc('usable_balance');
            $grid->header(function () use ($grid, $query) {
                $grid->model()->getQueries()->unique()->each(function ($v) use ($query) {
                    if (in_array($v['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) return;
                    call_user_func_array([$query, $v['method']], $v['arguments'] ?? []);
                });
                return $this->statistics($query);
            });
            $grid->export();
            $grid->model()->orderByDesc('user_id');
            $grid->withBorder();
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableRowSelector();

            $grid->column('user_id', '用户UID');
            $grid->column('user.referrer', Admin::user()->roles[0]->name . 'UID');
            $grid->column('margin_name');
            $grid->column('usable_balance')->sortable();
            $grid->column('used_balance');
            $grid->column('freeze_balance');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('user_id', '用户UID')->width(4);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(4);
                $filter->equal('user.referrer', Admin::user()->roles[0]->name . 'UID')->width(4);
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
        return Show::make($id, new SustainableAccount(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('coin_id');
            $show->field('coin_name');
            $show->field('margin_name');
            $show->field('usable_balance');
            $show->field('used_balance');
            $show->field('freeze_balance');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new SustainableAccount(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('coin_id');
            $form->text('coin_name');
            $form->text('margin_name');
            $form->text('usable_balance');
            $form->text('used_balance');
            $form->text('freeze_balance');
        });
    }
}
