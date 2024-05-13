<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 18:31:44
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-05 10:26:01
 */

namespace App\Admin\Actions\User;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\RowAction;
use App\Admin\Forms\User\UpdateToPlace as UpdateToPlaceForm;
use App\Admin\Extensions\Widgets\Modal;

class UpdateToPlace extends RowAction
{
    protected $title = "升为渠道商";


    public function  render()
    {
        $form = UpdateToPlaceForm::make()->payload(['id' => $this->getKey()]);

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
