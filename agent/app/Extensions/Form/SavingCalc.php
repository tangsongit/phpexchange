<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 09:37:26
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-07-31 09:43:09
 */

namespace App\Extensions\Form;

use Dcat\Admin\Form\Field;

class SavingCalc extends Field
{

    public function savingCalc(\Closure $closure)
    {
        $this->savingCallbacks[] = $closure;

        return $this;
    }
}
