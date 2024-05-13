<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-27 16:43:03
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 15:08:14
 */

namespace App\Admin\Forms\Place;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AgentUser;
use Dcat\Admin\Traits\LazyWidget;

class ToBeAgent extends Form
{
    use LazyWidget;
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return Response
     */
    public function handle(array $input)
    {
        $user_id = $this->payload['id'];
        // 表单验证
        $validator = Validator::make($input, [
            "rebate_rate" => "required|numeric|min:0|max:100",
            "rebate_rate_exchange" => "nullable|numeric|min:0|max:100",
            "rebate_rate_subscribe" => "nullable|numeric|min:0|max:100",
            "rebate_rate_contract" => "nullable|numeric|min:0|max:100",
            "rebate_rate_option" => "nullable|numeric|min:0|max:100"
        ]);

        try {
            DB::beginTransaction();
            // 1、更改用户表中用户身份为代理
            User::find($user_id)->update(['is_agency' => 1]);
            // 2、存储代理信息
            AgentUser::find($user_id)->update([
                "rebate_rate" => $input['rebate_rate'] / 100,
                "rebate_rate_exchange" => $input['rebate_rate_exchange'] ? $input['rebate_rate_exchange'] / 100 : null,
                "rebate_rate_subscribe" => $input['rebate_rate_subscribe'] ? $input['rebate_rate_subscribe'] / 100 : null,
                "rebate_rate_contract" => $input['rebate_rate_contract'] ? $input['rebate_rate_contract'] / 100 : null,
                "rebate_rate_option" => $input['rebate_rate_option'] ? $input['rebate_rate_option'] / 100 : null
            ]);
            // 3、增加权限至代理表
            DB::table('agent_admin_role_users')->insertOrIgnore(["role_id" => 2, "user_id" => $user_id]);
            DB::commit();
            // 4、发送信息通知用户
            return $this->success('升级成功');
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return $this->error('升级失败');
        }
    }

    /**
     * Build a form here.
     */
    public function form()
    {

        $this->rate('rebate_rate', '手续费返佣率(默认)')->required()->help('默认手续费返佣率，（币币、申购、合约、期权）为空时将会默认采用此返佣率进行计算');
        $this->radio('详细设置')
            ->when(1, function (Form $form) {
                $form->rate('rebate_rate_exchange', '币币返佣率')->help('币币交易手续费返佣率');
                $form->rate('rebate_rate_subscribe', '申购返佣率')->help('申购手续费返佣率');
                $form->rate('rebate_rate_contract', '合约返佣率')->help('合约交易手续费返佣率');
                $form->rate('rebate_rate_option', '期权返佣率')->help('期权交易手续费返佣率');
            })->options([0 => '隐藏', 1 => '显示'])->default(0);
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
