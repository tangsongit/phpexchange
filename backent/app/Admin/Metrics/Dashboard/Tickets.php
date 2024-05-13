<?php

namespace App\Admin\Metrics\Dashboard;

use App\Models\Recharge;
use App\Models\Withdraw;
use Dcat\Admin\Widgets\Metrics\RadialBar;
use Illuminate\Http\Request;
use App\Services\ExchangeRateService\ExchangeRateService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Tickets extends RadialBar
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $this->title('财务统计（USDT）');
        $this->height(400);
        $this->chartHeight(300);
        $this->chartLabels('充值提现比');
        $this->dropdown([
            '1' => '今天',
            '7' => '最近7天',
            '30' => '本月',
            '365' => '本年',
        ]);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        $base_recharge = Recharge::query()->where('status', 1)->select(['coin_name', 'amount']);
        $base_withdraw = Withdraw::query()->where('status', 3)->select(['coin_name', 'amount']);
        switch ($request->get('option')) {
            case '365':
                $base_recharge = $base_recharge->whereYear('created_at', Carbon::now()->format('Y'));
                $base_withdraw = $base_withdraw->whereYear('created_at', Carbon::now()->format('Y'));
                break;
            case '30':
                $base_recharge = $base_recharge->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'));
                $base_withdraw = $base_withdraw->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'));
                break;
            case '7':
                $base_recharge = $base_recharge->whereBetween('datetime', [Carbon::now()->subDays(7)->timestamp, Carbon::now()->timestamp]);
                $base_withdraw = $base_withdraw->whereBetween('datetime', [Carbon::now()->subDays(7)->timestamp, Carbon::now()->timestamp]);
                break;
            default:
                $base_recharge = $base_recharge->whereBetween('datetime', [Carbon::today()->timestamp, Carbon::now()->timestamp]);
                $base_withdraw = $base_withdraw->whereBetween('datetime', [Carbon::today()->timestamp, Carbon::now()->timestamp]);
        }
        //总入金
        $recharge_group = $base_recharge
            ->get()
            ->groupBy('coin_name')
            ->map(function ($v) {
                return $v->sum('amount');
            });
        // dd($recharge_group);
        $total_recharge = 0;
        foreach ($recharge_group as $coin_name => $amount) { //换算为USDT单位
            // 获取对应币种汇率
            if (strtolower($coin_name) == 'usdt') {
                $rate = 1;
            } else {
                $key = 'market:' . strtolower($coin_name . 'usdt') . '_newPrice';
                $rate = Cache::store('redis')->get($key)['price'];
            }
            // $rate = (new ExchangeRateService())->getCurrencyExCny($coin_name)['price_usd'] ?? 0;
            $total_recharge += $rate * $amount;
        }
        //总出金
        $withdraw_group = $base_withdraw
            ->get()
            ->groupBy('coin_name')
            ->map(function ($v) {
                return $v->sum('amount');
            });
        $total_withdraw = 0;
        foreach ($withdraw_group as $coin_name => $amount) {    //换算为USDT单位
            // 获取对应币种汇率
            $rate = (new ExchangeRateService())->getCurrencyExCny($coin_name)['price_usd'] ?? 0;
            $total_withdraw += $rate * $amount;
        }
        // 净入金 
        $income = $total_recharge - $total_withdraw;
        // 充值单数
        $recharge_count = $base_recharge->count();
        // 卡片内容
        $this->withContent($income);
        // 卡片底部
        $this->withFooter($total_recharge, $total_withdraw, $recharge_count);
        // 图表数据
        $this->withChart(empty($total_recharge) ? 0 : (bcdiv($total_withdraw, $total_recharge, 2) * 100));
    }

    /**
     * 设置图表数据.
     *
     * @param int $data
     *
     * @return $this
     */
    public function withChart(int $data)
    {
        return $this->chart([
            'series' => [$data],
        ]);
    }

    /**
     * 卡片内容
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex flex-column flex-wrap text-center">
    <h1 class="font-lg-2 mt-2 mb-0">{$content}</h1>
    <small>净入金</small>
</div>
HTML
        );
    }

    /**
     * 卡片底部内容.
     *
     * @param string $new
     * @param string $open
     * @param string $response
     *
     * @return $this
     */
    public function withFooter($new, $open, $response)
    {
        return $this->footer(
            <<<HTML
<div class="d-flex justify-content-between p-1" style="padding-top: 0!important;">
    <div class="text-center">
        <p>总充值</p>
        <span class="font-lg-1">{$new}</span>
    </div>
    <div class="text-center">
        <p>总提现</p>
        <span class="font-lg-1">{$open}</span>
    </div>
    <div class="text-center">
        <p>充值笔数</p>
        <span class="font-lg-1">{$response}</span>
    </div>
</div>
HTML
        );
    }
}
