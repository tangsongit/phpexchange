<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\OptionSceneOrder\Handle;
use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\BonusLog;
use App\Models\OptionSceneOrder;
use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

use Dcat\Admin\Admin;
use App\Admin\Actions\User\AddSystemUser;
use App\Admin\Actions\User\AddUser;
use App\Admin\Renderable\Parents;

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
        $query = OptionSceneOrder::with(['user', 'scene']);
        return Grid::make($query, function (Grid $grid) use ($query) {
            
              $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableQuickEdit();
                //$actions->disableEdit();
                $actions->disableView();

               $actions->append(new \App\Admin\Actions\kongzhi());
                  //  $actions->append(new \App\Admin\Actions\User\recharge());
                   
                
            });

         
            $grid->model()->orderByDesc("created_at");

            #统计
            $grid->header(function () use ($query, $grid) {
                $grid->model()->getQueries()->unique()->each(function ($v) use ($query) {
                    if (in_array($v['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) return;
                    call_user_func_array([$query, $v['method']], $v['arguments'] ?? []);
                });
                return $this->statistics($query);
            });

            $grid->fixColumns(1);

           // $grid->disableActions();
            $grid->disableBatchDelete();
            $grid->disableCreateButton();

            $grid->user_id;
            $grid->column('user.referrer', '代理')->display(function ($v) {
                return Agent::query()->where('id', $v)->value('name');
            });
            $grid->bet_amount;
            $grid->bet_coin_name;
            $grid->odds;
            $grid->range;
            $grid->column("涨跌平")->display(function () {
                if ($this->up_down == "1") {
                    return "<span style='color:red'>涨</span>";
                } else if ($this->up_down == "2") {
                    return "<span style='color:green'>跌</span>";
                } elseif ($this->up_down == 3) {
                    return "<span style='color:dodgerblue'>平</span>";
                }
            });

            $grid->status->using(OptionSceneOrder::$statusMap)->dot([1 => 'primary', 2 => 'success']);
            $grid->fee->display(function ($v) {
                return $v . ' ' . $this->bet_coin_name;
            });
            $grid->delivery_amount;
            $grid->delivery_time->display(function ($v) {
                return blank($v) ? null : date("Y-m-d H:i:s", $v);
            });
            $grid->column('scene.begin_price', "开盘价");
            $grid->column('scene.end_price', "收盘价");
            $grid->column('scene.delivery_up_down', "<span style='color: red'>涨</span><span style='color: darkgreen'>跌</span><span style='color: #0d77e4'>平</span>")->display(function ($d) {
                if ($d == 1) {
                    return "<span style='color:red'>涨 </span>";
                } else if ($d == 2) {
                    return "<span style='color:green'>跌 </span>";
                } elseif ($d == 3) {
                    return "<span style='color:dodgerblue'>平 </span>";
                }
            });

            $grid->created_at->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('created_at', "时间")->datetime();
                $filter->equal('user_id', '用户UID')->width(2);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(4);
                //                $filter->like('order_no', '订单号')->width(3);
                $filter->where('pid', function ($query) {
                    $referrer = $this->input;
                    $query->whereHas('user', function ($query) use ($referrer) {
                        $query->where('pid', $referrer);
                    });
                }, '代理商UID')->width(3);
                $filter->where('agent_id', function ($query) {
                    $base_ids = collect(User::getChilds($this->input))->pluck('user_id');
                    $query->whereHas('user', function ($query) use ($base_ids) {
                        $query->whereIn('user_id', $base_ids);
                    });
                }, '代理商UID')->width(3);
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
