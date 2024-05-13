<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-27 16:43:03
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-07-30 10:06:06
 */

namespace App\Admin\Forms\User;

use App\Models\User;
use App\Services\UserWalletService;
use Carbon\Carbon;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AddUser extends Form
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
        DB::beginTransaction();
        try {

            $data['account_type'] = $input['account_type'];
            if ($data['account_type'] == 1) {
                $data['account'] = $input['account'];
                $data['username'] = $input['account'];
                $data['phone'] = $input['account'];
                $data['phone_status'] = 1;
            } else {
                $data['account'] = $input['account'];
                $data['username'] = $input['account'];
                $data['email'] = $input['account'];
                $data['email_status'] = 1;
            }
            $data['reg_ip'] = request()->getClientIp();
            $data['invite_code'] = User::gen_invite_code();
            $data['password'] = (new User())->passwordHash($input['password']);
            $loginCode = User::gen_login_code(6);
            $data['login_code'] = $loginCode;
            $data['last_login_time'] = Carbon::now()->toDateTimeString();
            $data['last_login_ip'] = $data['reg_ip'];

            $data['country_id'] = 1;
            $data['country_code'] = 86;
            $data['referrer'] = ($input['referrer'] ?: $input['pid']) ?: 0; //当代理ID未填写时默认等于上级ID
            $data['pid'] = $input['pid'] ?? 0;
            $data['deep'] = 0;
            $data['is_system'] = 0;
            $data['contract_deal'] = 1;

            //创建用户
            $user = User::query()->create($data);
            // 创建用户钱包
            $result3 = (new UserWalletService())->createWallet($user);

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
        $this->radio('account_type')->options([1 => '手机', 2 => '邮箱'])->default(1)->required();
        $this->text('account')->required();
        $this->text('password')->required();
        $this->text('pid', '邀请人UID');
        $this->text('referrer', '代理商UID')->help('为空时默认与上级ID相等');
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
