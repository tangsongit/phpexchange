<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 20:59:13
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-07-31 21:32:25
 */

namespace App\Admin\Extensions\Widgets;

use Dcat\Admin\Widgets\Modal as oldModal;
use Dcat\Admin\Support\Helper;

class Modal extends oldModal
{
    protected $canClick = true;
    protected function renderButton()
    {
        if (!$this->button) {
            return;
        }

        $button = Helper::render($this->button);
        $data_toggle = $this->canClick ? 'modal' : '';
        $disabled = $this->canClick ? '' : 'disabled';
        // 如果没有HTML标签则添加一个 a 标签
        if (!preg_match('/(\<\/[\d\w]+\s*\>+)/i', $button)) {
            $button = "<button class=\"btn btn-sm btn-outline-primary {$disabled}\" >{$button}</button>";
        }
        return <<<HTML
<span style="cursor: pointer" data-toggle="{$data_toggle}" data-target="#{$this->id()}">{$button}</span>
HTML;
    }

    public function canClick($boolean)
    {
        $this->canClick = $boolean;
        return $this;
    }
}
