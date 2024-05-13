<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 15:23:07
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-18 17:42:24
 */

namespace App\Admin\Actions\Place;

use Dcat\Admin\Admin;
use Dcat\Admin\Actions\Action;

class AddPlace extends Action
{

    protected $title = '创建渠道商';

    public function render()
    {
        $id = get_order_sn('su');

        // 模态窗
        $this->modal($id);

        return <<<HTML
<span class="grid-expand" data-toggle="modal" data-target="#{$id}">
   <a class="btn btn-sm btn-outline-primary" href="javascript:void(0)">{$this->title}</a>
</span>
HTML;
    }
    protected function modal($id)
    {
        // 工具表单
        $form = new \App\Admin\Forms\Place\AddPlace();

        // 通过 Admin::html 方法设置模态窗HTML
        Admin::html(
            <<<HTML
<div class="modal fade" id="{$id}">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{$this->title}</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        {$form->render()}
      </div>
    </div>
  </div>
</div>
HTML
        );
    }
}
