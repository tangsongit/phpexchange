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
use App\Models\KuangjCycle;
use App\Models\KuangjiList;
use App\Models\Coins;

class KuangjCycleController extends AdminController
{
    protected $title = '矿机周期';

    protected function grid()
    {
        return Grid::make(KuangjCycle::with(['coins','coink']), function (Grid $grid) {

           



          
            $grid->id;
            $grid->column('kuang_id', '矿机id');
            $grid->column('coins.coin_name', '质押币种');
            $grid->column('coink.coin_name', '产出币种');
            $grid->column('cycle', '周期');
            $grid->column('amount', '质押数量');
            $grid->column('annualized_rate', '年化率');
            // $grid->status->switch();

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
        return Show::make($id, new KuangjCycle(), function (Show $show) {
           
            $show->kuang_id;
            $show->coin_id;
            $show->cycle;
            $show->coink_id;
            $show->amount;
            $show->status;
            $show->annualized_rate;
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
        return Form::make(new KuangjCycle(), function (Form $form) {
             $arr = [];
            $options = Coins::query()->where('status', 1)->orderByDesc('coin_id')->pluck('coin_name', 'coin_id')->toArray();
           $options2 = KuangjiList::query()->get()->toArray();
            foreach ($options2 as $v){
                $arr[$v['id']]=$v['k_name_zh'];
            }
           
          
            $form->select('coin_id')->options($options);
            $form->select('coink_id')->options($options);
            $form->text('amount','质押数量');
            $form->text('annualized_rate','年化率');
            $form->select('kuang_id')->options($arr);
            $form->text('cycle','周期');
            $form->saving(function (Form $form) use ($options) {
                if ($form->isCreating() || $form->isEditing()) {
                    if (!blank($form->quote_coin_id)) {
                        $quote_coin_id = $form->quote_coin_id;
                        //                    dd($quote_coin_id);
                        $quote_coin_name = $options[$quote_coin_id];
                        $base_coin_id = $form->base_coin_id;
                        $base_coin_name = $options[$base_coin_id];
                        if ($quote_coin_id == $base_coin_id) {
                            return $form->error('参数错误~');
                        }
                        $form->quote_coin_id = $quote_coin_id;
                        $form->quote_coin_name = $quote_coin_name;
                        $form->base_coin_id = $base_coin_id;
                        $form->base_coin_name = $base_coin_name;
                        $form->pair_name = $base_coin_name . '/' . $quote_coin_name;
                        $form->symbol = strtolower($base_coin_name . $quote_coin_name);
                    }
                }
            });
        });
    }
}
