<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-30 20:22:15
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-18 18:31:04
 */

namespace App\Admin\Forms\Place;

use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\AgentUser;
use Dcat\Admin\Admin;
use Illuminate\Support\Facades\DB;

class AddPlace extends Form
{

    use LazyWidget; //使用异步加载功能

    public function __construct()
    {
        parent::__construct();
        $this->place_id = Admin::user()->id;
        $this->agent_rate = AgentUser::find($this->place_id)
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
        // 判断此ID是否是自己的下级（防止抓包修改其他渠道商数据）
        if (blank(
            User::query() //判断该渠道商是否有权升级该用户
                ->where('user_id', $input['user_id'])
                ->where('is_place', 0)
                ->where('pid', $this->place_id)
                ->first()
        )) return $this->response()->error('该用户不是您的直接邀请人');


        // 设置反利率不得大于当前渠道商利率
        $agent_rate = $this->agent_rate;
        $min_rate = min(collect($agent_rate)->reject(function ($v) {
            return is_null($v) ? true : false;
        })->toArray() ?: [0]);
        // 表单验证
        $validator = Validator::make($input, [
            "user_id" => "numeric",
            "remark" => 'nullable|string', //备注
            "name"  => 'nullable|string', //渠道商名称
            "username" => "string",   //登录名
            "password" => "string", //登录密码
            "password2" => "same:password", //确认密码
            "rebate_rate" => "nullable|numeric|min:0|max:" . $min_rate,
            "rebate_rate_exchange" => "nullable|numeric|min:0|max:" . $agent_rate['rebate_rate_exchange'] ?: $min_rate,
            "rebate_rate_subscribe" => "nullable|numeric|min:0|max:" . $agent_rate['rebate_rate_subscribe'] ?: $min_rate,
            "rebate_rate_contract" => "nullable|numeric|min:0|max:" . $agent_rate['rebate_rate_contract'] ?: $min_rate,
            "rebate_rate_option" => "nullable|numeric|min:0|max:" . $agent_rate['rebate_rate_option'] ?: $min_rate
        ]);
        // 用户名查重
        if (AgentUser::isUsernameExist($input['username'])) return $this->response()->error('该用户名已存在');
        $create_data = [
            'id' => $input['user_id'],
            'remark' => $input['remark'],
            'name' => $input['name'],
            'username' => $input['username'],
            'password' => $input['password'],
            'rebate_rate' => $input['rebate_rate'], //默认分佣费率
            'rebate_rate_exchange' => $input['rebate_rate_exchange'], //币币交易分佣费率
            'rebate_rate_subscribe' => $input['rebate_rate_subscribe'], //申购分佣费率
            'rebate_rate_contract' => $input['rebate_rate_contract'], //合约分佣费率
            'rebate_rate_option' => $input['rebate_rate_option'] //期权分佣费率
        ];
        if ($validator->fails()) {
            return $this->response()->error($validator->errors()->first());
        }

        try {
            DB::beginTransaction();
            // 1、更改用户表中用户身份为渠道商
            User::find($input['user_id'])->update(['is_place' => 1]);
            // 2、存储渠道商信息
            AgentUser::create($create_data);
            // 3、添加渠道商权限至权限表中
            DB::table('agent_admin_role_users')->updateOrInsert(["role_id" => 3, "user_id" => $input['user_id']]);
            // 4、将下级用户的referrer字段修改成当前用户(未存在其他渠道商情况下)
            User::query()
                ->where('pid', $input['user_id'])
                ->where('referrer', 0)
                ->update(['referrer' => $input['user_id']]);
            DB::commit();
            // 5、发送信息通知用户
            return $this->response()->success('创建成功')->refresh();
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return $this->response()->error('创建失败');
        }
    }
    public function form()
    {
        $agent_rate = $this->agent_rate;
        $min_rate = $this->min_rate;
        $this->text('user_id', '渠道商UID')->required();
        $this->rate('rebate_rate', '手续费分佣率(默认)')->help('默认手续费分佣率，（币币、申购、合约、期权）为空时将会默认采用此分佣率进行计算,你的默认分佣比例为' . $agent_rate['rebate_rate'] . '%,请输入小于该值，<br>注：渠道商分佣比例将不生效');
        $this->radio('详细设置')
            ->when(1, function (Form $form) use ($agent_rate, $min_rate) {
                $form->rate('rebate_rate_exchange', '币币返佣率')->placeholder("<=" . $agent_rate['rebate_rate_exchange'] ?: $min_rate)->help('你的币币手续费分佣率比例为' . $agent_rate['rebate_rate_exchange'] . '%,请输入小于该值');
                $form->rate('rebate_rate_subscribe', '申购返佣率')->placeholder("<=" . $agent_rate['rebate_rate_subscribe'] ?: $min_rate)->help('你的申购手续的分佣率比例为' . $agent_rate['rebate_rate_subscribe'] . '%,请输入小于该值');
                $form->rate('rebate_rate_contract', '合约返佣率')->placeholder("<=" . $agent_rate['rebate_rate_contract'] ?: $min_rate)->help('你的合约手续费分佣率比例为' . $agent_rate['rebate_rate_contract'] . '%,请输入小于该值');
                $form->rate('rebate_rate_option', '期权返佣率')->placeholder("<=" . $agent_rate['rebate_rate_option'] ?: $min_rate)->help('你的期权手续费分佣率比例为' . $agent_rate['rebate_rate_option'] . '%,请输入小于该值');
            })->options([0 => '隐藏', 1 => '显示'])->default(0);
        $this->text('remark', '备注');
        $this->text('name', '渠道商名称')->help('渠道商显示的用户名称');
        $this->text('username', '登录名')->required()->help('登录名用于登录渠道商后台，无法修改');
        $this->password('password', '登录密码')->required();
        $this->password('password2', '确定密码')->required();
    }
    // public function default()
    // {
    //     return [];
    // }
}
