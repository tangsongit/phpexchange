<?php

namespace App\Admin\Controllers\Option;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\OptionSceneOrder;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

class OptionSceneOrderController extends AdminController
{

    public function statistics($query)
    {
        $base_data = $query->get(['delivery_amount', 'bet_amount', 'fee']);
        // 统计下单金额 下单量  中奖人数 
        $count = $base_data->count(); //下单量
        $bet_amount = $base_data->sum('bet_amount');  //下单金额
        $winer = $base_data->where('delivery_amount', '>', 0)->count(); //中奖人数
        $loser = $count - $winer;   //没中奖人数
        $con = "<code> 下单量: {$count}</code> ";
        $con .= "<code> 下的金额: {$bet_amount}</code> ";
        $con .= "<code> 中奖人数: {$winer}</code> ";
        $con .= "<code> 没中奖人数: {$loser}</code> ";
        return Alert::make($con, '统计')->info();
    }

    /**
     *期权订单
     *
     * @return Grid
     */
    protected $title = "期权订单";

    protected function grid()
    {
        $user_id = Admin::user()->id;
        $base_ids = collect(User::getChilds($user_id))->pluck('user_id')->toArray();
        $base_ids[] = $user_id;
        $query = OptionSceneOrder::with(['user', 'scene'])
            ->whereIn('user_id', $base_ids);
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->model()->orderByDesc("created_at");
            $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disableCreateButton();
            $grid->withBorder();
            #统计
            $grid->header(function () use ($query, $grid) {
                $grid->model()->getQueries()->unique()->each(function ($v) use ($query) {
                    if (in_array($v['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) return;
                    call_user_func_array([$query, $v['method']], $v['arguments'] ?? []);
                });
                return $this->statistics($query);
            });
            $grid->export();
            // 字段选择
            $grid->showColumnSelector();
            $grid->hideColumns(['scene.scene_sn']);
            // 组合表头
            $grid->combine('用户下单', ['range', 'up_down', 'created_at', 'fee', 'delivery_amount']);
            $grid->combine('交割结果', ['status', 'scene.begin_price', 'scene.end_price', 'scene.delivery_range', 'scene.delivery_up_down', 'delivery_time']);

            $grid->column("order_no", "订单号");
            $grid->column('user_id', '用户UID');
            $grid->column('user.pid', '邀请人UID');
            $grid->column('user.referrer', Admin::user()->roles[0]->name . 'UID');
            $grid->column('bet_coin_name', '币种名称');
            $grid->column('bet_amount', '委托金额')->append(function () {
                return " {$this->bet_coin_name}";
            })->help('用户下注的金额<br>(单位：USDT)');
            $grid->column('odds', '赔率')->percentage()->help('用户买中后按照<br>(赔率*委托金额*手续费)进行资金奖励');
            $grid->column('range')->percentage()->display(function ($v) {
                if ($this->up_down == 1) { //涨
                    return "<span style='color:red'>≥{$v}</span>";
                } else if ($this->up_down == 2) { //跌
                    return "<span style='color:green'>≥{$v}</span>";
                } elseif ($this->up_down == 3) { //平
                    return "<span style='color:dodgerblue'>≤{$v}</span>";
                }
            });
            $grid->column("up_down", '涨跌平')->display(function ($v) {
                if ($v == "1") {
                    return "<span style='color:red'>涨</span>";
                } else if ($v == "2") {
                    return "<span style='color:green'>跌</span>";
                } elseif ($v == 3) {
                    return "<span style='color:dodgerblue'>平</span>";
                }
            });
            $grid->column('status', '状态')->using(OptionSceneOrder::$statusMap)->dot([1 => 'primary', 2 => 'success']);
            $grid->column('fee', '手续费')->append(function () {
                return " {$this->bet_coin_name}";
            });
            $grid->column('delivery_amount', '交割金额');
            $grid->column('delivery_time', '交割时间')->datetime();
            $grid->column('scene.begin_price', "开盘价");
            $grid->column('scene.end_price', "收盘价");
            $grid->column('scene.delivery_range', '幅度绝对值')->percentage()->display(function ($v) {
                if ($this->scene->delivery_up_down == 1) { //涨
                    return "<span style='color:red'>≥{$v}</span>";
                } else if ($this->scene->delivery_up_down == 2) { //跌
                    return "<span style='color:green'>≥{$v}</span>";
                } elseif ($this->scene->delivery_up_down == 3) { //平
                    return "<span style='color:dodgerblue'>≤{$v}</span>";
                }
            });
            $grid->column('scene.delivery_up_down', "<span style='color: red'>涨</span><span style='color: darkgreen'>跌</span><span style='color: #0d77e4'>平</span>")->display(function ($d) {
                if ($d == 1) {
                    return "<span style='color:red'>涨 </span>";
                } else if ($d == 2) {
                    return "<span style='color:green'>跌 </span>";
                } elseif ($d == 3) {
                    return "<span style='color:dodgerblue'>平 </span>";
                }
            });

            $grid->column('created_at', '下单时间')->sortable();
            $grid->column('scene.scene_sn', '场景编号');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('created_at', "时间")->datetime();
                $filter->equal('user_id', '用户UID')->width(3);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(3);
                $filter->like('order_no', '订单号')->width(3);
                $filter->like('scene.scene_sn', '场景编号')->width(3);
                $filter->where('pid', function ($query) {
                    $referrer = $this->input;
                    $query->whereHas('user', function ($query) use ($referrer) {
                        $query->where('referrer', $referrer);
                    });
                }, Admin::user()->roles[0]->name . 'UID')->width(3);
                $filter->where('agent_id', function ($query) {
                    $base_ids = collect(User::getChilds($this->input))->pluck('user_id');
                    $query->whereIn('user_id', $base_ids);
                }, '链上查询')->width(3);
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
        return Show::make($id, new OptionSceneOrder(), function (Show $show) {
            $show->order_id;
            $show->order_no;
            $show->user_id;
            $show->bet_amount;
            $show->bet_coin_name;
            $show->odds;
            $show->range;
            $show->up_down;
            $show->status;
            $show->fee;
            $show->delivery_amount;
            $show->delivery_time;
            $show->created_at;
            $show->updated_at;
            $show->panel()
                ->tools(function ($tools) {
                    $tools->disableEdit();
                    //$tools->disableList();
                    $tools->disableDelete();
                });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new OptionSceneOrder(), function (Form $form) {
            $form->display('order_id');
            $form->text('order_no');
            $form->text('user_id');
            $form->text('bet_amount');
            $form->text('bet_coin_name');
            $form->text('odds');
            $form->text('range');
            $form->text('up_down');
            $form->text('status');
            $form->text('fee');
            $form->text('delivery_amount');
            $form->text('delivery_time');
            $form->display('created_at');
            $form->display('updated_at');

            if ($form->isCreating()) {
            }

            if ($form->isEditing()) {

                $form->saved(function (Form $form) {
                });
            }
        });
    }
}
