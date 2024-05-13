<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-13 15:57:59
 */

namespace App\Admin\Controllers;

use App\Models\ContractShare;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ContractShareController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ContractShare(), function (Grid $grid) {
            $grid->column('id')->sortable();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableQuickEdit();
                //                $actions->disableEdit();
                $actions->disableView();
            });
            $grid->column('type', '涨跌')->radio(['1' => '涨', 2 => '跌']);
            $grid->column('created_at')->display(function ($v) {
                return date('Y-m-d H:i:s', $v);
            });
            $grid->column('bg_img')->image();
            $grid->column('text_img')->image();
            $grid->column('peri_img')->image();
            $grid->column('status')->switch();


            $grid->filter(function (Grid\Filter $filter) {
                //                $filter->equal('id');

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
        return Show::make($id, new ContractShare(), function (Show $show) {
            $show->field('id');
            $show->field('data');
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
        return Form::make(ContractShare::with('translations'), function (Form $form) {
            $form->display('id');
            $form->radio('type', '涨跌')->options([
                1 => '涨',
                2 => '跌'
            ]);
            $form->hasMany('translations', '标题', function (Form\NestedForm $form) {
                $form->select('locale', '语言')->options([
                    'en' => '英文',
                    'zh-CN' => '中文',
                    "zh-TW" => "繁体",
                    'kor' => '韩文',
                    'jp' => '日文',
                    'de' => '德文',
                    'it' => '意大利文',
                    'nl' => '荷兰文',
                    'pl' => '波兰文',
                    'pt' => '葡萄牙文',
                    'spa' => '西班牙文',
                    'swe' => '瑞典文',
                    'tr' => '土耳其文',
                    'uk' => '乌克兰文',
                ])->default('zh-CN');
                $form->text('title', '标题');
            });

            $form->image('bg_img', '背景图')->uniqueName()->autoUpload()->disableRemove();
            $form->image('text_img', '文字图')->uniqueName()->autoUpload()->disableRemove();
            $form->image('peri_img', '人物图')->uniqueName()->autoUpload()->disableRemove();

            $form->switch('status')->default(1);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
