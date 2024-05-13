<?php

namespace App\Admin\Controllers\Contract;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\ContractWearPositionRecord;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

class ContractWearPositionRecordController extends AdminController
{
    public function statistics($query)
    {
        $base_data = $query->get(['loss']);

        $total = $base_data->count();
        $total_loss = $base_data->sum('loss');

        $con = '<code>总记录数：' . $total . '</code> ' . '<code>穿仓损失：' . $total_loss . ' USDT' . '</code> ';
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
        $query = ContractWearPositionRecord::query()
            ->whereIn('user_id', $base_ids);
        return Grid::make($query, function (Grid $grid) use ($query) {

            #统计
            $grid->header(function () use ($grid, $query) {
                $grid->model()->getQueries()->unique()->each(function ($v) use ($query) {
                    if (in_array($v['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) return;
                    call_user_func_array([$query, $v['method']], $v['arguments'] ?? []);
                });
                return $this->statistics($query);
            });
            $grid->export();

            $grid->model()->orderByDesc('id');
            $grid->withBorder();

            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->disableActions();

            $grid->column('user_id', '用户UID');
            $grid->column('symbol', '币种');
            $grid->column('position_side')->using([1 => '多', 2 => '空'])->label([1 => 'info', 2 => 'danger']);
            $grid->column('open_position_price');
            $grid->column('close_position_price');
            if (Admin::user()->inRoles([3])) {
                $grid->column('profit');
                $grid->column('settle_profit');
                $grid->column('loss');
            }
            $grid->column('created_at', '时间');

            $grid->filter(function (Grid\Filter $filter) {

                $filter->between('created_at', '时间')->datetime();
                $filter->equal('user_id')->width(3);
                $filter->equal('symbol', '币种')->width(3);
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
        return Show::make($id, new ContractWearPositionRecord(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('contract_id');
            $show->field('symbol');
            $show->field('position_side');
            $show->field('open_position_price');
            $show->field('close_position_price');
            $show->field('profit');
            $show->field('settle_profit');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ContractWearPositionRecord(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('contract_id');
            $form->text('symbol');
            $form->text('position_side');
            $form->text('open_position_price');
            $form->text('close_position_price');
            $form->text('profit');
            $form->text('settle_profit');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
