<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-17 10:41:19
 */


namespace App\Admin\Renderable;


use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Support\LazyRenderable;
use App\Admin\Metrics\Agent as AgentCard;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Card;

class TradeStatistics extends LazyRenderable
{

    public function render()
    {
        $id = $this->key;

        $row = new Row();
        $row->column(3, function (Column $column) {
            $column->row(new AgentCard\TotalUsers());
        });
        $row->column(3, function (Column $column) {
            $column->row(new AgentCard\Contract());
        });
        $row->column(3, function (Column $column) {
            $column->row(new AgentCard\Option());
        });
        $row->column(3, function (Column $column) {
            $column->row(new AgentCard\Exchange());
        });

        return Card::make('', $row);
    }
}
