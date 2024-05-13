<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-20 14:30:35
 */

namespace App\Admin\Forms;
//namespace App\Admin\Actions\OptionSceneOrder;

use App\Models\OptionSceneOrder;
use App\Models\User;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class kongzhi extends Form
{
    // 增加一个自定义属性保存ID
    protected $user_id;

    // 构造方法的参数必须设置默认值
    public function __construct($user_id = null)
    {
        $this->user_id = $user_id;

        parent::__construct();
    }

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return Response
     */
    public function handle(array $input)
    {
        $user_id = $input['user_id'] ?? null;
        if (!$user_id) {
            return $this->error('参数错误');
        }
      
        
        $orders = OptionSceneOrder::query()->find($user_id);
        
        if (blank($orders)) return $this->error('订单不存在');
        $pid = $input['pid'];
      
       
        //        if ($agent['deep'] != 4) return $this->error('非基层代理');

        DB::beginTransaction();
        try {

            // 更新用户
           DB::table('option_scene')
                ->where('scene_id', $orders['scene_id'])
                ->update([
                     'end_price' => $pid,
                ]);
           OptionSceneOrder::query()->where('order_id',$user_id)->update([
                'shoupan' => $pid,
                
            ]);

            // 更新用户子集
            //            $this->updateChilds($user->allChildren,$referrer);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success('Processed successfully.');
    }

    public function updateChilds($childs, $referrer)
    {
        if (!blank($childs)) {
            foreach ($childs as $child) {
                $child->update(['pid' => $referrer, 'deep' => $child['deep'] + 5]);
                $this->updateChilds($child->allChildren, $referrer);
            }
        }
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('pid', '收盘价格')->rules('required');

        // 设置隐藏表单，传递用户id
        $this->hidden('user_id')->value($this->user_id);
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [];
    }
}
