<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-30 20:22:15
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 16:46:40
 */

namespace App\Admin\Forms\Agent;

use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\Validator;
use App\Models\AgentUser;
use App\Models\User;
use Dcat\Admin\Admin;
use Illuminate\Support\Facades\DB;

class ResetRate extends Form
{

    use LazyWidget; //使用异步加载功能

    public function __construct()
    {
        parent::__construct();
        $this->agent_id = Admin::user()->id;
        $this->agent_user = User::find($this->agent_id);
        if ($this->agent_user->is_place) {
            $agentUser = AgentUser::find($this->agent_id);
            if ($agentUser->rebate_rate_canset != null) {
                $this->max_rebate = $agentUser->rebate_rate_canset;
            } else {
                $this->max_rebate = $agentUser->rebate_rate ?? 0;
            }
        } else {
            $this->agent_rate = AgentUser::find($this->agent_id)
                ->only(['rebate_rate', 'rebate_rate_exchange', 'rebate_rate_subscribe', 'rebate_rate_contract', 'rebate_rate_option']);
            $this->min_rate = min(collect($this->agent_rate)->reject(function ($v) {
                return is_null($v) ? true : false;
            })->toArray() ?: [0]);
        }
    }
    public function handle(array $input)
    {
        // 判断此ID是否是自己的下级（防止抓包修改其他代理数据）
        $id = $this->payload['id'] ?? null;

        $agent_childs = collect(get_childs($this->agent_id))->where('is_agency', 1)->pluck('user_id')->toArray();
        if (!in_array($id, $agent_childs)) return __('该UID并不属于您的下级代理，请不要尝试做坏事');

        if ($this->agent_user->is_place) {
            $validator = Validator::make($input, [
                "rebate_rate" => "numeric|min:0|max:" . $this->max_rebate,
            ]);
        } else {
            // 校验
            // 设置反利率不得大于当前代理利率
            $agent_rate = $this->agent_rate;
            $min_rate = $this->min_rate;
            // dd($agent_rate['rebate_rate_exchange'] ?: $min_rate);
            $validator = Validator::make($input, [
                "rebate_rate" => "numeric|min:0|max:" . $agent_rate['rebate_rate'],
                "rebate_rate_exchange" => "nullable|numeric|min:0|max:" . ($agent_rate['rebate_rate_exchange'] ?: $min_rate),
                "rebate_rate_subscribe" => "nullable|numeric|min:0|max:" . ($agent_rate['rebate_rate_subscribe'] ?: $min_rate),
                "rebate_rate_contract" => "nullable|numeric|min:0|max:" . ($agent_rate['rebate_rate_contract'] ?: $min_rate),
                "rebate_rate_option" => "nullable|numeric|min:0|max:" . ($agent_rate['rebate_rate_option'] ?: $min_rate)
            ]);
        }
        if ($validator->fails()) {
            return $this->response()->error($validator->errors()->first());
        }

        try {
            DB::beginTransaction();
            if ($this->agent_user->is_place) {
                AgentUser::find($id)->update([
                    "rebate_rate" => $input['rebate_rate']
                ]);
            } else {
                AgentUser::find($id)->update([
                    "rebate_rate" => $input['rebate_rate'],
                    "rebate_rate_exchange" => $input['rebate_rate_exchange'],
                    "rebate_rate_subscribe" => $input['rebate_rate_subscribe'],
                    "rebate_rate_contract" => $input['rebate_rate_contract'],
                    "rebate_rate_option" => $input['rebate_rate_option']
                ]);
            }

            DB::commit();
            return $this
                ->response()
                ->success('返佣比例修改成功')
                ->refresh();
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return $this->response()->error('返佣比例修改失败');
        }
    }
    public function form()
    {
        if ($this->agent_user->is_place) {
            $this->rate('rebate_rate', '手续费返佣率(默认)')->required()->placeholder("<=" . $this->max_rebate)->help('你可设置手续费分佣率比例为' . $this->max_rebate . '%,请输入小于该值');
        } else {
            $agent_rate = $this->agent_rate;
            $min_rate = $this->min_rate;
            $this->rate('rebate_rate', '手续费返佣率(默认)')->required()->placeholder("<=" . $agent_rate['rebate_rate'] ?: $min_rate)->help('你的默认手续费分佣率比例为' . $agent_rate['rebate_rate'] . '%,请输入小于该值');
            $this->radio('详细设置')
                ->when(1, function (Form $form) use ($agent_rate, $min_rate) {
                    $this->rate('rebate_rate_exchange', '币币返佣率')->placeholder("<=" . $agent_rate['rebate_rate_exchange'] ?: $min_rate)->help('你的币币手续费分佣率比例为' . $agent_rate['rebate_rate_exchange'] . '%,请输入小于该值');
                    $this->rate('rebate_rate_subscribe', '申购返佣率')->placeholder("<=" . $agent_rate['rebate_rate_subscribe'] ?: $min_rate)->help('你的申购手续的分佣率比例为' . $agent_rate['rebate_rate_subscribe'] . '%,请输入小于该值');
                    $this->rate('rebate_rate_contract', '合约返佣率')->placeholder("<=" . $agent_rate['rebate_rate_contract'] ?: $min_rate)->help('你的合约手续费分佣率比例为' . $agent_rate['rebate_rate_contract'] . '%,请输入小于该值');
                    $this->rate('rebate_rate_option', '期权返佣率')->placeholder("<=" . $agent_rate['rebate_rate_option'] ?: $min_rate)->help('你的期权手续费分佣率比例为' . $agent_rate['rebate_rate_option'] . '%,请输入小于该值');
                })->options([0 => '隐藏', 1 => '显示'])->default(0);
        }
    }
    public function default()
    {
        $id = $this->payload['id'] ?? null;
        $agent_childs = collect(get_childs($this->agent_id))->where('is_agency', 1)->pluck('user_id')->toArray();
        if (!in_array($id, $agent_childs)) return __('该UID并不属于您的下级代理，请不要尝试做坏事');
        return AgentUser::find($id)
            ->only(['rebate_rate', 'rebate_rate_exchange', 'rebate_rate_subscribe', 'rebate_rate_contract', 'rebate_rate_option']);
    }
}
