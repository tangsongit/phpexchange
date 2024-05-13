<?php

namespace App\Admin\Controllers\Exchange;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\Coins;
use App\Models\InsideTradeOrder;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;
use App\Models\User;

class InsideTradeOrderController extends AdminController
{

    public function statistics($query)
    {
        global $con;
        $con = '';
        $query->get(['trade_buy_fee', 'trade_sell_fee', 'symbol', 'symbol'])
            ->groupBy('symbol')->each(function ($v, $k) use ($con) {
                global $con;
                $total_fee = $v->sum('trade_buy_fee') + $v->sum('trade_sell_fee');
                if ($total_fee > 0) {
                    $con .= "<code style=\"margin:5px\"> {$k}手续费：$total_fee </code>";
                }
            });
        return Alert::make($con, '统计')->info();
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected $title = "成交记录";


    protected function grid()
    {
        $user_id = Admin::user()->id;
        $base_ids = collect(User::getChilds($user_id))->pluck('user_id')->toArray();
        $base_ids[] = $user_id;
        $query = InsideTradeOrder::with(['buy_user', 'sell_user'])
            ->where(function ($query) use ($base_ids) {
                $query->whereIn('buy_user_id', $base_ids)
                    ->orWhereIn('sell_user_id', $base_ids);
            });
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->model()->orderByDesc("order_id");
            //统计
            $grid->header(function () use ($query, $grid) {
                $grid->model()->getQueries()->unique()->each(function ($v) use ($query) {
                    if (in_array($v['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) return;
                    call_user_func_array([$query, $v['method']], $v['arguments'] ?? []);
                });
                return $this->statistics($query);
            });
            $grid->export();
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableBatchDelete();
            $grid->disableDeleteButton();
            $grid->withBorder();

            $grid->buy_order_no;
            $grid->sell_order_no;
            $grid->column('buy_user_id', '买家用户UID');
            $grid->column('sell_user_id', '卖家用户UID');
            $grid->unit_price;
            $grid->symbol;
            $grid->trade_amount;
            $grid->trade_money;
            $grid->trade_buy_fee->display(function ($v) {
                return $v . ' ' . str_before($this->symbol, '/');
            });
            $grid->trade_sell_fee->display(function ($v) {
                return $v . ' ' . str_after($this->symbol, '/');
            });
            $grid->column('created_at')->sortable();
            //            $grid->updated_at->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('created_at', "时间")->datetime();
                $filter->where('user_id', function ($query) {
                    $user_id = $this->input;
                    $query->whereHas('buy_user', function ($query) use ($user_id) {
                        $query->where('user_id', $user_id);
                    })->orWhereHas('sell_user', function ($query) use ($user_id) {
                        $query->where('user_id', $user_id);
                    });
                }, '用户UID')->width(3);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('buy_user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    })->orWhereHas('sell_user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(3);
                $filter->where('referrer', function ($query) {
                    $referrer = $this->input;
                    $query->whereHas('buy_user', function ($query) use ($referrer) {
                        $query->where('referrer', $referrer);
                    })->orWhereHas('sell_user', function ($query) use ($referrer) {
                        $query->where('referrer', $referrer);
                    });
                }, '代理UID')->width(3);
                $filter->where('agent_id', function ($query) {
                    $base_ids = collect(User::getChilds($this->input))->pluck('user_id');
                    $query->where(function ($query) use ($base_ids) {
                        $query->whereIn('buy_user_id', $base_ids)
                            ->OrwhereIn('sell_user_id', $base_ids);
                    });
                }, '链上查询')->placeholder('输入' . Admin::user()->roles[0]->name . 'UID查询链上成交记录')->width(3);
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
        return Show::make($id, new InsideTradeOrder(), function (Show $show) {
            $show->order_id;
            $show->buy_order_no;
            $show->sell_order_no;
            $show->buy_id;
            $show->sell_id;
            $show->buy_user_id;
            $show->sell_user_id;
            $show->unit_price;
            $show->symbol;
            $show->quote_coin_id;
            $show->base_coin_id;
            $show->trade_amount;
            $show->trade_money;
            $show->trade_fee;
            $show->status;
            $show->created_at;
            $show->updated_at;
            $show->panel()
                ->tools(function ($tools) {
                    $tools->disableEdit();
                    $tools->disableList();
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
        return Form::make(new InsideTradeOrder(), function (Form $form) {
            $form->display('order_id');
            $form->text('buy_order_no');
            $form->text('sell_order_no');
            $form->text('buy_id');
            $form->text('sell_id');
            $form->text('buy_user_id');
            $form->text('sell_user_id');
            $form->text('unit_price');
            $form->text('symbol');
            $form->text('quote_coin_id');
            $form->text('base_coin_id');
            $form->text('trade_amount');
            $form->text('trade_money');
            $form->text('trade_fee');
            $form->text('status');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
