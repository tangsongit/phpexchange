<?php

namespace App\Admin\Controllers;

use App\Models\UserWalletErrorLogs;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ErrorLogController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected $title = '核验日记';
    protected function grid()
    {
        return Grid::make(new UserWalletErrorLogs(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->user_id;
            //$grid->account_type;
            $grid->column('account_type', '账户类型')->display(function () {
                if ($this->account_type == 1) $iden[] = '帐户资产';
                if ($this->account_type == 2) $iden[] = '合约资产';
                return $iden ?? [];
            })->label();
            $grid->rich_type;
            $grid->error_info;
            $grid->coin_id;
            $grid->coin_name;
            $grid->amount;
            $grid->error_amount;
            $grid->created_at;

            $grid->disableCreateButton();
//            $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->disableRowSelector();
            $grid->disableEditButton();


            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
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
        return Show::make($id, new UserWalletErrorLogs(), function (Show $show) {
            $show->id;
            //$show->name;
            //$show->url; //show 方法隐藏按钮

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new UserWalletErrorLogs(), function (Form $form) {
            $form->display('id');
            //$form->text('name');
            //$form->text('url');
        });
    }
}
