<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-02 17:12:19
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-02 17:58:26
 */


namespace App\Admin\Controllers\Agent;

use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;

class RebateLogsController extends AdminController
{

    protected $title = '代理分佣记录';

    public function grid()
    {

        return Grid::make();
    }
}
