<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-11 17:08:40
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-11 17:42:47
 */

namespace App\Admin\Controllers;

use App\Models\InvitePoster;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;

class InvitePosterController extends AdminController
{


    /**
     * @description: 
     * @param {*}
     * @return {*}
     */
    public function grid()
    {
        return Grid::make(new InvitePoster(), function (Grid $grid) {
            $grid->model()->orderByDesc('id');
            $grid->column('id')->sortable();
            $grid->column('image', '背景')->image();
            $grid->column('sort', '排序');
            $grid->column('status', '状态')->switch();
            $grid->column('is_default', '默认')->switch();
        });
    }
    public function form()
    {
        return Form::make(new InvitePoster(), function (Form $form) {
            $form->display('id');
            $form->image('image', '背景')->uniqueName()->move('poster')->autoUpload();
            $form->number('sort', '排序');
            $form->switch('status', '状态')->default(1);
            $form->switch('is_default', '默认');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
