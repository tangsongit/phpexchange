<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-30 20:22:15
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-20 16:47:49
 */

namespace App\Admin\Forms\Place;

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
        $this->agent_rate = AgentUser::find($this->agent_id)
            ->only(['place_rebate_rate']);
        $this->min_rate = min(collect($this->agent_rate)->reject(function ($v) {
            return is_null($v) ? true : false;
        })->toArray() ?: [0]);
    }
    public function handle(array $input)
    {
        // 判断此ID是否是自己的下级（防止抓包修改其他代理数据）
        $id = $this->payload['id'] ?? null;

        $agent_childs = collect(User::getChilds($this->agent_id))->where('is_place', 1)->pluck('user_id')->toArray();
        // dd($this->agent_id);
        if (!in_array($id, $agent_childs)) return __('该UID并不属于您的下级渠道商，请不要尝试做坏事');
        // 校验
        // 设置反利率不得大于当前代理利率
        $agent_rate = $this->agent_rate;
        $min_rate = $this->min_rate;
        // dd($agent_rate['rebate_rate_exchange'] ?: $min_rate);
        $validator = Validator::make($input, [
            "place_rebate_rate" => "nullable|numeric|min:0|max:" . $agent_rate['place_rebate_rate'],
        ]);
        if ($validator->fails()) {
            return $this->response()->error($validator->errors()->first());
        }

        try {
            DB::beginTransaction();
            AgentUser::find($id)->update([
                "place_rebate_rate" => $input['place_rebate_rate']
            ]);
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
        $agent_rate = $this->agent_rate;
        $min_rate = $this->min_rate;
        $this->rate('place_rebate_rate', '渠道商返佣比例')->required()->placeholder("<=" . $agent_rate['place_rebate_rate'] ?: $min_rate)->help('你的分佣率比例为' . $agent_rate['place_rebate_rate'] . '%,请输入小于该值');
    }
    public function default()
    {
        $id = $this->payload['id'] ?? null;
        $agent_childs = collect(get_childs($this->agent_id))->where('is_place', 1)->pluck('user_id')->toArray();
        if (!in_array($id, $agent_childs)) return __('该UID并不属于您的下级代理，请不要尝试做坏事');
        return AgentUser::find($id)
            ->only(['place_rebate_rate']);
    }
}
