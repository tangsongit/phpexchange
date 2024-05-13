<?php

namespace App\Admin\Controllers;

use App\Models\Coins;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form\Field\Table;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Form as WidgetsForm;

class CoinController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Coins(), function (Grid $grid) {
            $grid->model()
                ->orderByRaw("FIELD(status," . implode(",", [1, 0]) . ")")
                ->orderByDesc('order')
                ->orderByDesc('coin_id');

            $grid->disableDeleteButton();
            $grid->disableRowSelector();
            // $grid->disableCreateButton();
            $grid->disableViewButton();

            $grid->coin_id->sortable();
            $grid->coin_name;
            //            $grid->full_name;
            //            $grid->qty_decimals;
            //            $grid->price_decimals;
            $grid->withdrawal_fee->sortable()->display(function ($v) {
                return isJson($v) ? collect(json_decode($v, true))->map(function ($v) {
                    return "{$v['address_type']} : {$v['withdrawal_fee']}";
                }) : $v;
            })->label();
            $grid->withdrawal_min->sortable();
            $grid->withdrawal_max->sortable();
            //            $grid->coin_withdraw_message;
            //            $grid->coin_recharge_message;
            //            $grid->coin_transfer_message;
            $grid->coin_content->display('详情') // 设置按钮名称
                ->expand(function () {
                    // 返回显示的详情
                    // 这里返回 content 字段内容，并用 Card 包裹起来
                    $card = new Card(null, $this->coin_content);

                    return "<div style='padding:10px 10px 0'>$card</div>";
                });;
            $grid->coin_icon->image('', 50, 50);
            $grid->column('order', '排序');
            $grid->status->using([0 => '禁用', 1 => '启用'])->dot([0 => 'danger', 1 => 'success'])->switch();
            $grid->created_at->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('coin_id')->width(3);
                $filter->like('coin_name', '币种名称')->width(3);
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
        return Show::make($id, new Coins(), function (Show $show) {
            $show->coin_id;
            $show->coin_name;
            $show->qty_decimals;
            $show->price_decimals;
            $show->full_name;
            $show->withdrawal_fee;
            $show->coin_withdraw_message;
            $show->coin_recharge_message;
            $show->coin_transfer_message;
            $show->coin_content;
            $show->coin_icon;
            $show->status;
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
        return Form::make(new Coins(), function (Form $form) {
            $form->display('coin_id');
            $form->text('coin_name');
            $form->text('full_name');
            $form->number('qty_decimals')->default(2);
            $form->number('price_decimals')->default(2);
            if ($form->model()->coin_id == 1) {
                $form->table('withdrawal_fee', function (NestedForm $table) {
                    $table->text('address_type', '链名');
                    $table->text('withdrawal_fee', '提币手续费');
                })->customFormat(function ($v) {
                    return isJson($v) ? json_decode($v, true) : '';
                });
            } else {
                $form->text('withdrawal_fee', '提币手续费');
            }
            $form->text('total_issuance', '发行总量');
            $form->text('total_circulation', '流通总量');
            $form->text('crowdfunding_price', '发行价格');
            $form->datetime('publish_time', '发行时间');
            $form->text('white_paper_link', '白皮书连接');
            $form->text('official_website_link', '官网连接');
            $form->text('withdrawal_min');
            $form->text('withdrawal_max');
            $form->text('coin_withdraw_message');
            $form->text('coin_recharge_message');
            $form->text('coin_transfer_message');
            $form->editor('coin_content');
            $form->image('coin_icon');
            $form->number('order', '排序（权重）')->help('数值越大排的越前');
            $form->switch('can_recharge', '可后台充值？')->default(0);
            $form->switch('status')->default(1);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
