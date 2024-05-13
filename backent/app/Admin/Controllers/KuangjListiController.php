<?php

namespace App\Admin\Controllers;


use App\Admin\Renderable\UserTradeStatistics;
use App\Admin\Renderable\UserWalletExpand;
use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\Country;
use App\Models\User;
use App\Models\UserGrade;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Admin\Actions\User\AddSystemUser;
use App\Admin\Actions\User\AddUser;
use App\Admin\Renderable\Parents;
use App\Models\KuangjiList;

class KuangjListiController extends AdminController
{
    protected $title = '矿机列表';

    protected function grid()
    {
        return Grid::make(new KuangjiList(), function (Grid $grid) {

           



          
            $grid->id;
            //            $grid->account;
            //            $grid->username;
          
            $grid->column('k_name_zh', '矿机名称');
            $grid->column('max_amount', '最大数量');
            $grid->column('min_amount', '最小数量');
        
           

            //            $grid->disableViewButton();
            // $grid->disableCreateButton();
            // //$grid->disableEditButton();
            // $grid->disableDeleteButton();
            // $grid->disableBatchDelete();

           
        });
    }

    // public function agents(Request $request)
    // {
    //     $q = $request->get('q');
    //     $options = Agent::query()->where(['pid' => $q, 'is_agency' => 1])->select(['id', 'username as text'])->get()->toArray();
    //     array_unshift($options, []);
    //     return $options;
    // }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new KuangjiList(), function (Show $show) {
           
            $show->k_name_zh;
            $show->max_amount;
            $show->min_amount;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new KuangjiList(), function (Form $form) {

         
            $form->text('k_name_zh','矿机名称');
            $form->text('max_amount','最大数量');
            $form->text('min_amount','最小数量');
        });
    }
}
