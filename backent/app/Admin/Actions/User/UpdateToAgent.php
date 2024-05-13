<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 18:31:44
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-05 10:26:20
 */

namespace App\Admin\Actions\User;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\RowAction;
use App\Admin\Forms\User\UpdateToAgent as UpdateToAgentForm;
use App\Admin\Extensions\Widgets\Modal;

class UpdateToAgent extends RowAction
{
    protected $title = "升为代理";


    public function  render()
    {
        $form = UpdateToAgentForm::make()->payload(['id' => $this->getKey()]);

        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            ->canClick(($this->row->is_place == 1) || ($this->row->is_agency == 1) ? false : true)
            ->button($this->title);
    }

    public function html()
    {

        $this->setHtmlAttribute(['class' => 'btn btn-primary btn-sm btn-mini submit']);
        return parent::html();
    }
}
