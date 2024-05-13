<?php

namespace App\Admin\Controllers;

use App\Models\WalletInfo;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class WalletInfoController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected $title = '钱包地址';
    protected function grid()
    {
        return Grid::make(new WalletInfo(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->name;
            $grid->address;

            $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->disableRowSelector();


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
        return Show::make($id, new WalletInfo(), function (Show $show) {
            $show->id;
            $show->name;
            $show->address; //show 方法隐藏按钮

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new WalletInfo(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('address');
        });
    }
}
