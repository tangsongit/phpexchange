<?php
/*
 * @Descripttion: 用户升级为渠道商逻辑
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 18:43:21
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-09-10 18:01:15
 */

namespace App\Admin\Forms\User;

use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\AgentUser;
use App\Models\User;

class UpdateToPlace extends Form
{


    use LazyWidget;

    public function handle(array $input)
    {
        $user_id = $this->payload['id'];
        // 表单验证
        $validator = Validator::make($input, [
            "user_id" => "required|numeric",
            "remark" => 'nullable|string', //备注
            "name"  => 'nullable|string', //姓名
            "username" => "required|string",   //登录名
            "password" => "required|string", //登录密码
            "password2" => "required|same:password", //确认密码
            "place_rebate_rate" => "required" //渠道商返佣比例
        ]);

        // 查找用户名是否存在
        if (AgentUser::isUsernameExist($input['username'])) return $this->error('用户名已存在');
        try {
            DB::beginTransaction();
            // 1、更改用户表中用户身份为代理
            User::find($user_id)->update(['is_place' => 1]);
            // 2、存储代理信息
            AgentUser::updateOrCreate(
                ['id' => $user_id],
                [
                    "remark" => $input['remark'] ?: null, //备注
                    "name"  => $input['name'], //姓名
                    "place_rebate_rate" => $input['place_rebate_rate'], //渠道商返佣比例
                    "username" => $input['username'],   //登录名
                    "password" => $input['password'], //登录密码
                ]
            );
            // 3、增加权限至代理表
            DB::table('agent_admin_role_users')->insertOrIgnore(["role_id" => 3, "user_id" => $input['user_id']]);
            DB::commit();
            // 4、发送信息通知用户
            return $this->success('升级成功');
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return $this->error('升级失败');
        }
    }
    public function form()
    {
        $this->hidden('user_id', '渠道商UID');
        $this->text('remark', '备注');
        $this->text('name', '姓名')->help('渠道商后台显示用户昵称');
        $this->text('username', '登录名')->required()->help('登录名用于登录代理商后台，无法修改');
        $this->rate('place_rebate_rate', '返佣比例')->required()->help('渠道商返佣比例，该比例用于记录用户返佣比例，最终返佣由管理员手动进行');
        $this->password('password', '登录密码')->required();
        $this->password('password2', '确定密码')->required();
    }
    public function default()
    {
        return [
            'user_id' => $this->payload['id']
        ];
    }
}
