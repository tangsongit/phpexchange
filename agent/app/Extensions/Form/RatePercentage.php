<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-30 20:57:44
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-07-30 21:31:24
 */

namespace App\Extensions\Form;

use Dcat\Admin\Form\Field\Text;

class RatePercentage extends Text
{
    public function render()
    {
        $this->prepend('%')->defaultAttribute('placeholder', 0)->saving(function ($v) {
            return $v / 100;
        });

        return parent::render();
    }
}
