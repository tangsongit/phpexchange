<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 18:43:21
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-27 18:07:56
 */

namespace App\Admin\Forms\User;

use App\Models\Agent;
use Dcat\Admin\Admin;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\AgentUser;
use App\Models\User;

class UpdateToAgent extends Form
{


    use LazyWidget;

    public function __construct()
    {
        parent::__construct();
        $this->agent_id = Admin::user()->id;
        $this->agent_rate = AgentUser::find($this->agent_id)
            ->only([
                'rebate_rate', //默认分佣费率
                'rebate_rate_exchange', //币币交易分佣费率
                'rebate_rate_subscribe', //申购分佣费率
                'rebate_rate_contract', //合约分佣费率
                'rebate_rate_option' //期权分佣费率
            ]);
        $this->min_rate = min(collect($this->agent_rate)->reject(function ($v) {
            return is_null($v) ? true : false;
        })->toArray() ?: [0]);
    }
    public function handle(array $input)
    {
        // 判断此ID是否是自己的下级（防止抓包修改其他代理数据）
        $user_id = $this->payload['id'] ?? null;
        $user = User::find($user_id);
        $is_place = $user->is_place == 1;
        $agent_childs = collect(get_childs($this->agent_id))->where('is_agency', 0)->pluck('user_id')->toArray();
        if (!in_array($user_id, $agent_childs)) return $this->response()->error('该UID并不属于您的下级代理，请不要尝试做坏事');
        // 表单验证
        // 设置反利率不得大于当前代理利率
        $agent_rate = $this->agent_rate;
        $min_rate = $this->min_rate;

        if ($is_place) {
            $AdminUser =  AgentUser::find($this->agent_id);

            if ($AdminUser->rebate_rate_canset != null) {
                $max_rebate = $AdminUser->rebate_rate_canset;
            } else {
                $max_rebate = $AdminUser->rebate_rate ?? 0;
            }
            $validator = Validator::make($input, [
                "user_id" => "required|numeric",
                "rebate_rate" => "numeric|min:0|max:" . $max_rebate,
            ]);
        } else {
            $validator = Validator::make($input, [
                "user_id" => "required|numeric",
                "remark" => 'nullable|string', //备注
                "name"  => 'nullable|string', //代理名称
                "username" => "required|string",   //登录名
                "password" => "required|string", //登录密码
                "password2" => "required|same:password", //确认密码
                "rebate_rate" => "numeric|min:0|max:" . $agent_rate['rebate_rate'],
                "rebate_rate_exchange" => "nullable|numeric|min:0|max:" . ($agent_rate['rebate_rate_exchange'] ?: $min_rate),
                "rebate_rate_subscribe" => "nullable|numeric|min:0|max:" . ($agent_rate['rebate_rate_subscribe'] ?: $min_rate),
                "rebate_rate_contract" => "nullable|numeric|min:0|max:" . ($agent_rate['rebate_rate_contract'] ?: $min_rate),
                "rebate_rate_option" => "nullable|numeric|min:0|max:" . ($agent_rate['rebate_rate_option'] ?: $min_rate)
            ]);
            if (AgentUser::isUsernameExist($input['username'])) return $this->response()->error('用户名已存在');
        }
        if ($validator->fails()) {
            return $this->response()->error($validator->errors()->first());
        }

        try {
            DB::beginTransaction();
            // 1、更改用户表中用户身份为代理
            User::find($user_id)->update(['is_agency' => 1]);
            // 2、存储代理信息(分种情况1、用户本身是渠道商 2、用户不是渠道商)
            if ($is_place) {
                AgentUser::find($user_id)->update(
                    ["rebate_rate" => $input['rebate_rate']]
                );
            } else {
                AgentUser::updateOrCreate(
                    ["id" => $user_id],
                    [
                        "remark" => $input['remark'] ?: null, //备注
                        "name"  => $input['name'], //代理名称
                        "username" => $input['username'],   //登录名
                        "password" => $input['password'], //登录密码
                        "rebate_rate" => $input['rebate_rate'],
                        "rebate_rate_exchange" => $input['rebate_rate_exchange'],
                        "rebate_rate_subscribe" => $input['rebate_rate_subscribe'],
                        "rebate_rate_contract" => $input['rebate_rate_contract'],
                        "rebate_rate_option" => $input['rebate_rate_option']
                    ]
                );
            }

            // 3、增加权限至代理表
            DB::table('agent_admin_role_users')->updateOrInsert(["role_id" => 2, "user_id" => $input['user_id']]);
            // 4、将下级用户的referrer字段改为当前代理商(如果不存在其他上级代理的情况下)
            User::query()
                ->where('pid', $user_id)
                ->where('referrer', 0)
                ->update(['referrer' => $user_id]);
            DB::commit();
            // 5、发送信息通知用户
            return $this->response()
                ->success('升级成功')
                ->refresh();
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            dd($e);
            return $this->response()->error('升级失败');
        }
    }
    public function form()
    {
        $AdminUser =  AgentUser::find($this->agent_id);

        if ($AdminUser->rebate_rate_canset != null) {
            $max_rebate = $AdminUser->rebate_rate_canset;
        } else {
            $max_rebate = $AdminUser->rebate_rate ?? 0;
        }

        $this->user = User::find($this->payload['id']);
        $is_place = $this->user->is_place == 1; //判断该用户是否属于渠道商
        $agent_rate = $this->agent_rate;
        $min_rate = $this->min_rate;
        $this->hidden('user_id', '代理商UID');
        if (!$is_place) {
            $this->rate('rebate_rate', '手续费返佣率(默认)')->required()->placeholder("<=" . $agent_rate['rebate_rate'] ?: $min_rate)->help('你的默认手续费分佣率比例为' . $agent_rate['rebate_rate'] . '%,请输入小于该值');
            $this->radio('详细设置')
                ->when(1, function (Form $from) use ($agent_rate, $min_rate) {
                    $from->rate('rebate_rate_exchange', '币币返佣率')->placeholder("<=" . $agent_rate['rebate_rate_exchange'] ?: $min_rate)->help('你的币币手续费分佣率比例为' . $agent_rate['rebate_rate_exchange'] . '%,请输入小于该值');
                    $from->rate('rebate_rate_subscribe', '申购返佣率')->placeholder("<=" . $agent_rate['rebate_rate_subscribe'] ?: $min_rate)->help('你的申购手续的分佣率比例为' . $agent_rate['rebate_rate_subscribe'] . '%,请输入小于该值');
                    $from->rate('rebate_rate_contract', '合约返佣率')->placeholder("<=" . $agent_rate['rebate_rate_contract'] ?: $min_rate)->help('你的合约手续费分佣率比例为' . $agent_rate['rebate_rate_contract'] . '%,请输入小于该值');
                    $from->rate('rebate_rate_option', '期权返佣率')->placeholder("<=" . $agent_rate['rebate_rate_option'] ?: $min_rate)->help('你的期权手续费分佣率比例为' . $agent_rate['rebate_rate_option'] . '%,请输入小于该值');
                })->options([0 => '隐藏', 1 => '显示'])->default(0);
            $this->text('remark', '备注');
            $this->text('name', '代理名称')->help('代理显示的用户名称');
            $this->text('username', '登录名')->required()->help('登录名用于登录代理商后台，无法修改');
            $this->password('password', '登录密码')->required();
            $this->password('password2', '确定密码')->required();
        } elseif ($is_place) {
            $this->rate('rebate_rate', '手续费返佣率(默认)')->required()->placeholder("<=" . $agent_rate['rebate_rate'] ?: $min_rate)->help('你可设置手续费分佣率比例为' . $max_rebate . '%,请输入小于该值');
        }
    }
    public function default()
    {
        return [
            'user_id' => $this->payload['id']
        ];
    }
}
