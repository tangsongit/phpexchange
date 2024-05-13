<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 18:43:21
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-27 18:12:15
 */

namespace App\Admin\Forms\User;

use Dcat\Admin\Admin;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\AgentUser;
use App\Models\User;

class UpdateToPlace extends Form
{


    use LazyWidget;

    public function __construct()
    {
        parent::__construct();
        $this->agent_id = Admin::user()->id;
        $this->agent_rate = AgentUser::find($this->agent_id)
            ->only([
                'place_rebate_rate', //渠道商分佣费率
            ]);
    }
    public function handle(array $input)
    {
        // 判断此ID是否是自己的下级（防止抓包修改其他渠道数据）
        $user_id = $this->payload['id'] ?? null;
        $user = User::find($user_id);
        $agent_childs = collect(get_childs($this->agent_id))->where('is_place', 0)->pluck('user_id')->toArray();
        if (!in_array($user_id, $agent_childs)) return $this->response()->error('该UID并不属于您的下级渠道，请不要尝试做坏事');
        // 表单验证
        // 设置反利率不得大于当前渠道利率
        $agent_rate = $this->agent_rate;
        if ($user->is_agency) {
            $validator = Validator::make($input, [
                "user_id" => "required|numeric",
                "place_rebate_rate" => "nullable|numeric|min:0|max:" . $agent_rate['place_rebate_rate']
            ]);
        } else {
            $validator = Validator::make($input, [
                "user_id" => "required|numeric",
                "remark" => 'nullable|string', //备注
                "name"  => 'nullable|string', //渠道名称
                "username" => "required|string",   //登录名
                "password" => "required|string", //登录密码
                "password2" => "required|same:password", //确认密码
                "place_rebate_rate" => "nullable|numeric|min:0|max:" . $agent_rate['place_rebate_rate']
            ]);
            if (AgentUser::isUsernameExist($input['username'])) return $this->response()->error('用户名已存在');
        }
        if ($validator->fails()) {
            return $this->response()->error($validator->errors()->first());
        }

        try {
            DB::beginTransaction();
            // 1、更改用户表中用户身份为渠道
            User::find($user_id)->update(['is_place' => 1]);
            // 2、存储渠道信息
            if ($user->is_agency) {
                AgentUser::find($user_id)->update(
                    [
                        "place_rebate_rate" => $input['place_rebate_rate'],
                    ]
                );
            } else {
                AgentUser::updateOrCreate(
                    ['id' => $user_id],
                    [
                        "remark" => $input['remark'] ?: null, //备注
                        "name"  => $input['name'], //渠道名称
                        "username" => $input['username'],   //登录名
                        "password" => $input['password'], //登录密码
                        "place_rebate_rate" => $input['place_rebate_rate'],
                    ]
                );
            }
            // 3、增加权限至渠道表
            DB::table('agent_admin_role_users')->updateOrInsert(["role_id" => 3, "user_id" => $input['user_id']]);
            // 4、将下级用户的referrer字段改为当前渠道商(如果不存在其他上级渠道的情况下)
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
            return $this->response()->error('升级失败');
        }
    }
    public function form()
    {
        $user = User::find($this->payload['id'] ?? null);
        $agent_rate = $this->agent_rate;
        $this->hidden('user_id', '渠道商UID');
        $this->rate('place_rebate_rate', '渠道商返佣比例')->placeholder("<=" . $agent_rate['place_rebate_rate'])->help('你的分佣率比例为' . $agent_rate['place_rebate_rate'] . '%,请输入小于该值');
        if (!$user->is_agency) {
            $this->text('remark', '备注');
            $this->text('name', '渠道名称')->help('渠道显示的用户名称');
            $this->text('username', '登录名')->required()->help('登录名用于登录渠道商后台，无法修改');
            $this->password('password', '登录密码')->required();
            $this->password('password2', '确定密码')->required();
        }
    }
    public function default()
    {
        return [
            'user_id' => $this->payload['id']
        ];
    }
}
