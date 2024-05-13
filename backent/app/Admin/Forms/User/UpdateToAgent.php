<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 18:43:21
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-13 14:48:03
 */

namespace App\Admin\Forms\User;

use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\AgentUser;
use App\Models\User;

class UpdateToAgent extends Form
{


    use LazyWidget;

    public function handle(array $input)
    {
        $user_id = $this->payload['id'];
        // 表单验证
        $validator = Validator::make($input, [
            "user_id" => "required|numeric",
            "remark" => 'nullable|string', //备注
            "name"  => 'nullable|string', //代理名称
            "username" => "required|string",   //登录名
            "password" => "required|string", //登录密码
            "password2" => "required|same:password", //确认密码
            "rebate_rate" => "required|numeric|min:0|max:100",
            "rebate_rate_exchange" => "nullable|numeric|min:0|max:100",
            "rebate_rate_subscribe" => "nullable|numeric|min:0|max:100",
            "rebate_rate_contract" => "nullable|numeric|min:0|max:100",
            "rebate_rate_option" => "nullable|numeric|min:0|max:100"
        ]);

        // 查找用户名是否存在
        if (AgentUser::isUsernameExist($input['username'])) return $this->error('用户名已存在');
        try {
            DB::beginTransaction();
            // 1、更改用户表中用户身份为代理
            User::find($user_id)->update(['is_agency' => 1]);
            // 2、存储代理信息
            AgentUser::updateOrCreate([
                'id' => $user_id
            ], [
                "remark" => $input['remark'] ?: null, //备注
                "name"  => $input['name'], //代理名称
                "username" => $input['username'],   //登录名
                "password" => $input['password'], //登录密码
                "rebate_rate" => $input['rebate_rate'],
                "rebate_rate_exchange" => $input['rebate_rate_exchange'] ?: null,
                "rebate_rate_subscribe" => $input['rebate_rate_subscribe'] ?: null,
                "rebate_rate_contract" => $input['rebate_rate_contract'] ?: null,
                "rebate_rate_option" => $input['rebate_rate_option'] ?: null
            ]);
            // 3、增加权限至代理表
            DB::table('agent_admin_role_users')->updateOrInsert(["role_id" => 2, "user_id" => $input['user_id']]);
            // 4、将下级用户的referrer 字段修改为当前用户(如果为0的情况下)
            User::query()
                ->where('pid', $user_id)
                ->where('referrer', 0)
                ->update(['referrer' => $user_id]);
            DB::commit();
            // 5、发送信息通知用户
            return $this->success('升级成功');
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return $this->error('升级失败');
        }
    }
    public function form()
    {
        $this->hidden('user_id', '代理商UID');
        $this->rate('rebate_rate', '手续费返佣率(默认)')->required()->help('默认手续费返佣率，（币币、申购、合约、期权）为空时将会默认采用此返佣率进行计算');
        $this->radio('详细设置')
            ->when(1, function (Form $form) {
                $form->rate('rebate_rate_exchange', '币币返佣率')->help('币币交易手续费返佣率');
                $form->rate('rebate_rate_subscribe', '申购返佣率')->help('申购手续费返佣率');
                $form->rate('rebate_rate_contract', '合约返佣率')->help('合约交易手续费返佣率');
                $form->rate('rebate_rate_option', '期权返佣率')->help('期权交易手续费返佣率');
            })->options([0 => '隐藏', 1 => '显示'])->default(0);
        $this->text('remark', '备注');
        $this->text('name', '代理名称')->help('代理显示的用户名称');
        $this->text('username', '登录名')->required()->help('登录名用于登录代理商后台，无法修改');
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
