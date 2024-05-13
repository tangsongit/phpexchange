<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-30 20:22:15
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-19 18:24:44
 */

namespace App\Admin\Forms\Place;

use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\AgentUser;
use Dcat\Admin\Admin;
use Illuminate\Support\Facades\DB;

class ResetPassword extends Form
{

    use LazyWidget; //使用异步加载功能

    public function __construct()
    {
        parent::__construct();
        $this->agent_id = Admin::user()->id;
    }
    public function handle(array $input)
    {
        // 判断此ID是否是自己的下级（防止抓包修改其他代理数据）
        $id = $this->payload['id'] ?? null;

        $agent_childs = collect(User::getChilds($this->agent_id))->where('is_place', 1)->pluck('user_id')->toArray();
        if (!in_array($id, $agent_childs)) return __('该UID并不属于您的下级代理，请不要尝试做坏事');

        // 校验
        // 设置反利率不得大于当前代理利率
        $validator = Validator::make($input, [
            "password" => "string",
            "password2" => "same:password"
        ]);
        if ($validator->fails()) {
            return $this->response()->error($validator->errors()->first());
        }
        try {
            DB::beginTransaction();
            AgentUser::updateOrCreate(
                ['id' => $id],
                ['password' => $input['password']]
            );
            DB::commit();
            return $this
                ->response()
                ->success('修改成功')
                ->refresh();
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return $this->response()->error('修改失败');
        }
    }
    public function form()
    {
        $this->display('user_id', '用户UID');
        $this->password('password', '密码');
        $this->password('password2', '确定密码');
    }
    public function default()
    {
        return [
            'user_id' => $this->payload['id'] ?? null,
        ];
    }
}
