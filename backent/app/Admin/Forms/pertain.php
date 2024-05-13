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

use App\Models\User;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class pertain extends Form
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
        $user = User::query()->where('user_id', $user_id)->first();
        if (blank($user)) return $this->error('用户不存在');
        $pid = $input['pid'];
        $agent = User::query()->where(['user_id' => $pid])->find($pid);
        if (blank($agent)) return $this->error('代理不存在');
        //        if ($agent['deep'] != 4) return $this->error('非基层代理');

        DB::beginTransaction();
        try {

            // 更新用户
            $user->update([
                'pid' => $pid,
                'referrer' => $pid,
                'deep' => $user['deep'] + 1,
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
        $this->text('pid', '上级UID')->rules('required');

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
