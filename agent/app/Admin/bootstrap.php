<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-28 15:28:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-04 17:32:07
 */

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;

use Dcat\Admin\Grid\Column;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
Grid::resolving(function (Grid $grid) {
    $grid->disableBatchDelete();

    $grid->filter(function (Filter $filter) {
        $filter->panel();
        $filter->expand();
    });
});


// 注册路径别名
// Admin::asset()->alias('@css','a');
// 注册Css
Admin::css('css/agent.css');


// 将浮点数转化为百分比
Column::extend('percentage', function ($v) {
    return floatval(bcmul($v, 100, 1)) . '%';
});

// 以百分比显示并且输入数值也除以100
Form::extend('ratePer', App\Extensions\Form\RatePercentage::class);
// Form::extend('savingCalc', App\Extensions\Form\SavingCalc::class);
