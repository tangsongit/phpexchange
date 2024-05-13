<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-30 19:55:35
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-07-31 14:17:29
 */

namespace App\Admin\Actions\Agent;

use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Admin;
use App\Admin\Forms\Agent\ResetPassword as ResetPasswordForm;

class ResetPassword extends RowAction
{

    protected $title = "重置密码";

    public function render()
    {
        $id = "agent-reset-password-{$this->getKey()}";

        // 模拟窗
        $this->modal($id);

        return <<<HTML
<span class="grid-expand" data-toggle="modal" data-target="#{$id}">
    <a class="btn btn-sm btn-outline-primary nowrap" href="javascript:void(0)">$this->title </a>
</span>
HTML;
    }

    protected function modal($id)
    {
        // 工具表单
        $form = ResetPasswordForm::make()->payload(['id' => $this->getKey()]);

        //在弹窗标题处显示当行用户名，用户名不存在则显示用户ID
        $username = $this->row->name ?: $this->row->user_id;

        // 通过Admin::html方法设置模拟窗HTML
        Admin::html(
            <<<HTML
<div class="modal fade" id="{$id}">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">$this->title - {$username}</h4>
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

    /**
     * @description: 添加JS
     * @return {*}
     */
    protected function script()
    {
        return <<<JS

JS;
    }

    /**
     * @description: 
     * @return {*}
     */
    public function html()
    {
        $this->setHtmlAttribute(['class' => 'btn btn-primary btn-sm btn-mini submit']);
        return parent::html();
    }
}
