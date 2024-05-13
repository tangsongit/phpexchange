<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-27 16:43:03
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 15:08:11
 */

namespace App\Admin\Forms\Place;

use App\Models\User;
use App\Services\UserWalletService;
use Carbon\Carbon;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AgentUser;

class AddPlace extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return Response
     */
    public function handle(array $input)
    {
        // 判断用户是否存在
        $user_id = $input['user_id'];
        if (User::isUserExist($user_id)) return $this->error('该用户不存在，请先创建用户');
        DB::beginTransaction();
        try {
            // 1、将用户状态改成渠道商
            User::find($user_id)->update(['is_place' => 1]);
            // 2、将用户信息更新至代理商表
            AgentUser::updateOrCreate(
                ['user_id', $user_id],
                [
                    'name' => $input['name'],
                    'username' => $input['username'],
                    'password' => $input['password']
                ]
            );
            // 3、增加渠道商权限
            DB::table('agent_admin_role_users')->insertOrIgnore(["role_id" => 3, "user_id" => $input['user_id']]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success('添加成功');
    }

    /**
     * Build a form here.
     */
    public function form()
    {

        $this->text('user_id', '用户UID')->required()->help('请输入用户UID，点击确认后将用户升级为代理商');
        $this->text('name', '姓名');
        $this->text('username', '登录账号')->help('用于登录代理商后台');
        $this->text('password')->help('代理后台登录密码，若该用于已为代理那么该将重置该代理密码');
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
