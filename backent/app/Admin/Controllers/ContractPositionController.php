<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\ContractPosition\Flat;
use App\Admin\Actions\ContractPosition\OnekeyFlatPosition;
use App\Handlers\ContractTool;
use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\ContractPair;
use App\Models\ContractPosition;
use App\Models\ContractStrategy;
use App\Models\SustainableAccount;
use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;

class ContractPositionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $builder = ContractPosition::query()->where('hold_position', '>', 0);
        return Grid::make($builder, function (Grid $grid) {
            $grid->model()->orderByDesc('id');

            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableQuickEdit();
                $actions->disableEdit();
                $actions->disableView();

                $actions->append(new Flat());
            });

            $grid->tools([new OnekeyFlatPosition()]);

            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('symbol');
            $grid->column('side')->using([1 => '多', 2 => '空'])->label([1 => 'info', 2 => 'danger']);
            //            $grid->column('contract_id');
            //            $grid->column('unit_amount');
            $grid->column('lever_rate');
            $grid->column('hold_position');
            $grid->column('avail_position');
            $grid->column('freeze_position');
            $grid->column('position_margin');
            $grid->column('avg_price');
            $grid->column('unRealProfit', '预计收益')->display(function () {
                $realtime_price = Cache::store('redis')->get('swap:' . 'trade_detail_' . $this->symbol)['price'] ?? null;
                return ContractTool::unRealProfit($this, ['unit_amount' => $this->unit_amount], $realtime_price);
            });
            $grid->column('flatPrice', '预估强平价')->display(function () {
                $account = SustainableAccount::getContractAccount($this->user_id);
                $contract = ContractPair::query()->find($this->contract_id);
                return ContractTool::getFlatPrice($account, $contract);
            })->label();
            $grid->column('tp_price', '止盈价')->display(function () {
                return ContractStrategy::query()
                    ->where('status', 1)
                    ->where('user_id', $this->user_id)
                    ->where('contract_id', $this->contract_id)
                    ->where('position_side', $this->side)
                    ->first()->tp_trigger_price ?? '--';
            });
            $grid->column('sl_price', '止损价')->display(function () {
                return ContractStrategy::query()
                    ->where('status', 1)
                    ->where('user_id', $this->user_id)
                    ->where('contract_id', $this->contract_id)
                    ->where('position_side', $this->side)
                    ->first()->sl_trigger_price ?? '--';
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('user_id', '用户UID')->width(3);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(3);
                $filter->equal('symbol')->width(3);
                $filter->where('pid', function ($query) {
                    $base_ids = User::query()
                        ->where('pid', $this->input)
                        ->get('user_id')
                        ->pluck('user_id');
                    $query->whereIn('user_id', $base_ids);
                }, '代理商UID')->placeholder('输入代理商/渠道商/用户UID查看下级持仓信息')->width(3);
                $filter->where('agent_id', function ($query) {
                    $base_ids = collect(User::getChilds($this->input))->pluck('user_id');
                    $query->whereIn('user_id', $base_ids);
                }, '链上查询')->placeholder('输入代理商/渠道商/用户UID查看链上持仓信息')->width(3);
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
        return Show::make($id, new ContractPosition(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('side');
            $show->field('contract_id');
            $show->field('symbol');
            $show->field('unit_amount');
            $show->field('lever_rate');
            $show->field('hold_position');
            $show->field('avail_position');
            $show->field('freeze_position');
            $show->field('position_margin');
            $show->field('avg_price');
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
        return Form::make(new ContractPosition(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('side');
            $form->text('contract_id');
            $form->text('symbol');
            $form->text('unit_amount');
            $form->text('lever_rate');
            $form->text('hold_position');
            $form->text('avail_position');
            $form->text('freeze_position');
            $form->text('position_margin');
            $form->text('avg_price');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
