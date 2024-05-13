<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-05 10:46:43
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-05 11:32:23
 */


namespace App\Admin\Actions\Place;

use Dcat\Admin\Grid\RowAction;
use App\Admin\Forms\Place\ToBeAgent as ToBeAgentForm;
use App\Admin\Extensions\Widgets\Modal;

class ToBeAgent extends RowAction
{
    protected $title = "升为代理商";


    public function  render()
    {
        $form = ToBeAgentForm::make()->payload(['id' => $this->getKey()]);

        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            ->canClick(($this->row->is_agency == 1) ? false : true)
            ->button($this->title);
    }

    public function html()
    {

        $this->setHtmlAttribute(['class' => 'btn btn-primary btn-sm btn-mini submit']);
        return parent::html();
    }
}
