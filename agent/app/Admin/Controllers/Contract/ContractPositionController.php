<?php

namespace App\Admin\Controllers\Contract;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\ContractPosition;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;

use App\Models\SustainableAccount;
use App\Models\ContractPair;
use App\Models\Contract\ContractStrategy;
use App\Handlers\ContractTool;
use App\Models\AgentUser;

class ContractPositionController extends AdminController
{
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
        $builder = ContractPosition::with('user_auth')
            ->where('hold_position', '>', 0)
            ->whereIn('user_id', $base_ids);
        return Grid::make($builder, function (Grid $grid) {
            $grid->model()->orderByDesc('id');
            $grid->withBorder();

            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->disableBatchDelete();
            $grid->disableActions();
            $grid->export()->rows(function (array $rows) {
                foreach ($rows as $index => &$row) {
                    $parents = '';
                    $parent_arr = User::getParentUsers($row['user_id']);
                    foreach ($parent_arr as $v) {
                        $name = AgentUser::find($v->user_id)->remark ?? null;
                        if ($name) {
                            $parents .= $name . '/';
                        }
                        if ($v->user_id == Admin::user()->id) break;
                    }
                    $row['lead'] = substr($parents, 0, -1);
                }
                return $rows;
            });

            $grid->column('user_id');
            $grid->column('user_auth.realname', '用户姓名');
            $grid->column('symbol', '币种');
            $grid->column('side')->using([1 => '多', 2 => '空'])->label([1 => 'info', 2 => 'danger']);
            $grid->column('lever_rate');
            $grid->column('hold_position');
            $grid->column('avail_position');
            $grid->column('freeze_position');
            $grid->column('position_margin');
            $grid->column('avg_price');
            if (Admin::user()->inRoles([3])) {
                $grid->combine('渠道商专属', ['unRealProfit', 'flatPrice', 'tp_price', 'sl_price']);
                $grid->column('unRealProfit', '预计收益')->display(function () {
                    $realtime_price = Cache::store('redis')->get('swap:' . 'trade_detail_' . $this->symbol)['price'] ?? null;
                    return ContractTool::unRealProfit($this, ['unit_amount' => $this->unit_amount], $realtime_price);
                })->label();
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
                $grid->column('lead', '用户所属')->display(function ($v) {
                    $parents = '';
                    $parent_arr = User::getParentUsers($this->user_id);
                    foreach ($parent_arr as $v) {
                        $name = AgentUser::find($v->user_id)->remark ?? null;
                        if ($name) {
                            $parents .= $name . '/';
                        }
                        if ($v->user_id == Admin::user()->id) break;
                    }
                    return substr($parents, 0, -1);
                })->limit(15)->help('用户所属渠道/代理商，以合伙人备注显示');
            }

            $grid->filter(function (Grid\Filter $filter) {
                // $filter->between('created_at', '时间')->date();
                $filter->equal('user_id', '用户UID')->width(3);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(3);
                $filter->equal('symbol', '币种')->width(3);
                $filter->where('pid', function ($query) {
                    $base_ids = User::query()
                        ->where('pid', $this->input)
                        ->get('user_id')
                        ->pluck('user_id');
                    $query->whereIn('user_id', $base_ids);
                }, Admin::user()->roles[0]->name . 'UID')->placeholder('输入' . Admin::user()->roles[0]->name . '/用户UID查看下级持仓信息')->width(3);
                $filter->where('agent_id', function ($query) {
                    $base_ids = collect(User::getChilds($this->input))->pluck('user_id');
                    $query->whereIn('user_id', $base_ids);
                }, '链上查询')->placeholder('输入' . Admin::user()->roles[0]->name . '/用户UID查看链上持仓信息')->width(3);
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
