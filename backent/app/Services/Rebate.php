<?php
/*
 * @Descripttion: 级差分佣机制
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-02 18:30:00
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 19:56:11
 */


namespace App\Services;

use App\Models\User;
use App\Models\AgentUser;
use Illuminate\Support\Facades\DB;

class Rebate
{

    /**
     * @description: 根据用户UID与金额来计算分佣结果
     * @param {*} $user_id 用户UID
     * @param {*} $amount 分佣金额
     * @return {*} collect 返回用户分佣数组数据
     */
    public static function rebateLevelDiff(int $user_id, float $amount)
    {
        // 查询用户上级代理
        // 获取订单的上级代理列表
        $agents = collect(DB::table('agent_users')->get(['id', 'rebate_rate', 'rebate_rate_contract'])); //用于获取返佣率
        $parents_com_rate = collect(User::getParents($user_id))
            ->map(function ($v) use ($agents) {
                $user = $agents->where('id', $v)->first();
                $rate_default = $user->rebate_rate ?? 0; // 默认汇率
                $rate_contract = $user->rebate_rate_contract; // 合约汇率
                return [
                    'aid' => $v,
                    'rebate_rate' => $rate_contract ?? $rate_default,
                ];
            })->toArray();
        $base_rate = 0;
        // 开始创建分佣记录数据
        for ($i = 0; $i < count($parents_com_rate); $i++) {
            $this_agent = $parents_com_rate[$i];
            // $pre_agent = $parents_com_rate[$i - 1] ?? [];
            if ($i == 0) {
                $base_rate = $this_rate = $this_agent['rebate_rate'] ?? 0;
                if ($this_rate <= 0) continue;
            } else {
                $this_rate = ($this_agent['rebate_rate'] - $base_rate);
                if ($this_rate <= 0) continue;
                $base_rate = $this_rate + $base_rate;
            }
            $parents_com_rate[$i]['rebate'] = $this_rate * $amount;
            $parents_com_rate[$i]['user_referrer'] = $parents_com_rate[0]['aid']; //用户上级代理
        }
        return $parents_com_rate;
    }
}
