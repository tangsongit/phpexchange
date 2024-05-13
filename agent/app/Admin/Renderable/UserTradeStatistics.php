<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-28 15:28:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-17 15:11:46
 */


namespace App\Admin\Renderable;


use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Support\LazyRenderable;
use App\Admin\Metrics\User as UserCard;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Card;

class UserTradeStatistics extends LazyRenderable
{

    public function render()
    {
        $id = $this->key;

        $row = new Row();
        $row->column(3, function (Column $column) {
            $column->row(new UserCard\TotalUsers());
        });
        $row->column(3, function (Column $column) {
            $column->row(new UserCard\Contract());
        });
        $row->column(3, function (Column $column) {
            $column->row(new UserCard\Option());
        });
        $row->column(3, function (Column $column) {
            $column->row(new UserCard\Exchange());
        });

        return Card::make('', $row);
    }
}
