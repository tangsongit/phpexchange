<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 18:31:44
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-18 18:09:18
 */

namespace App\Admin\Actions\User;

use App\Models\User;
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
            ->canClick(($this->row->is_place == 1) ? false : true)
            ->button($this->title);
    }

    public function html()
    {

        $this->setHtmlAttribute(['class' => 'btn btn-primary btn-sm btn-mini submit']);
        return parent::html();
    }
    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        // 检查该代理是否属于该代理直属下级
        return blank(User::query()->where('user_id', $this->getKey())->where('pid', $user->user_id)) ? false : true;;
    }
}
