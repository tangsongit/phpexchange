<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-07-31 23:19:38
 */

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;

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

config(['app.locale' => config('admin.lang') ?: config('app.locale')]);

Grid::resolving(function (Grid $grid) {
    $grid->filter(function (Filter $filter) {
        $filter->panel();
        $filter->expand();
    });

    //    $grid->withBorder();
    $grid->tableCollapse(false);
});

// Grid::extend('calc', function ($value, $symbol, $number, $deciaml = 2) {
//     switch ($symbol) {
//         case '+':
//             return ($value + $number);
//         case '-';
//             return ($value - $number);
//         case '*':
//             return ($value * $number);
//         case '/':
//             return bcdiv($value, $number, $deciaml);
//     };
// });

Admin::css('static/css/nxcrm.css');
