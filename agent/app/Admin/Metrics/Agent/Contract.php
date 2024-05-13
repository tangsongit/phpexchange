<?php


namespace App\Admin\Metrics\Agent;


use App\Models\Agent;
use App\Models\ContractEntrust;
use App\Models\OptionBetCoin;
use App\Models\OptionSceneOrder;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Bar;
use Illuminate\Http\Request;
use App\Models\User;

class Contract extends Bar
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $color = Admin::color();

        $dark35 = $color->blue2();

        // 卡片内容宽度
        $this->contentWidth(11, 1);
        // 标题
        $this->title('合约交易(伞下)');

        // 设置下拉选项
        $coin_options = OptionBetCoin::query()->where('is_bet', 1)->orderBy('sort', 'desc')->orderBy('coin_id', 'asc')->pluck('coin_name', 'coin_id')->toArray();
        $this->dropdown($coin_options);
        // 设置图表颜色
        $this->chartColors([
            $dark35,
            $dark35,
            $dark35,
            $dark35,
            $dark35,
            $color->success(),
        ]);

        $this->request('POST', $this->getRequestUrl(), ['referrer' => request()->input('key')]); // 设置API请求地址 携带参数

        //        $this->handle(request());
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
        $referrer = $request->get('referrer', null);
        $base_ids = collect(User::getChilds($referrer))
            ->pluck("user_id")->toArray();

        $default_coin = OptionBetCoin::query()->where('is_bet', 1)->orderBy('sort', 'desc')->orderBy('coin_id', 'asc')->value('coin_id');
        $coin_id = $request->get('option', $default_coin);

        $builder1 = ContractEntrust::query()
            ->whereHas('user', function ($query) {
                $query->where('is_system', 0);
            })
            ->whereIn('user_id', $base_ids)
            ->whereNotIn('status', [0, 1])
            ->get(['fee', 'profit', 'created_at']);

        $builder2 = $builder1
            ->where('created_at', '>=', Carbon::today()->toDayDateTimeString())
            ->where('created_at', '<', Carbon::today()->addDay()->toDateTimeString());

        $value1 = $builder1->count();    //下单量
        $value2 = $builder1->sum('profit');  //用户盈亏
        $value3 = $builder1->sum('fee'); //总手续费

        $value4 = $builder2->count();    //下单量
        $value5 = $builder2->sum('profit');  //用户盈亏
        $value6 = $builder2->sum('fee'); //总手续费

        // 卡片内容
        $this->withContent($referrer, $value1, $value2, $value3, $value4, $value5, $value6);

        // // 图表数据
        // for ($i = 6; $i >= 0; $i--) {
        //     $chart_data[] = $builder1
        //         ->where('created_at', '>=', Carbon::today()->subDays($i))
        //         ->where('created_at', '<', Carbon::today()->subDays($i - 1))
        //         ->count();
        // }
        // $this->withChart([
        //     [
        //         'name' => 'Bet amount',
        //         'data' => $chart_data
        //     ],
        // ]);
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => $data,
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param int $referrer
     * @param string $value1
     * @param string $value2
     * @param string $value3
     * @param string $value4
     * @param string $value5
     * @param string $value6
     *
     * @return $this
     */
    public function withContent($referrer, string $value1, string $value2, string $value3, string $value4, string $value5, string $value6)
    {
        // 根据选项显示
        $label = strtolower(
            $this->dropdown[request()->option] ?? 'last 7 days'
        );

        $minHeight = '183px';
        $admin_url = admin_url();
        return $this->content(
            <<<HTML
<div class="d-flex p-1 flex-column justify-content-between" style="padding-top: 0;width: 100%;height: 100%;min-height: {$minHeight}">
    <div class="text-left">
        <div class="chart-info d-flex justify-content-between mb-1" >
          <div class="product-result" style="margin-left: 20px;">
              <span>类型</span>
          </div>
          <div class="product-result">
              <span>总计</span>
          </div>
          <div class="product-result">
              <span>今日</span>
          </div>
    </div>

        <div class="chart-info d-flex justify-content-between mb-1" >
                  <div class="series-info d-flex align-items-center">
                      <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                      <span class="text-bold-600 ml-50">用户总下单量</span>
                  </div>
                  <div class="product-result">
                      <span>{$value1}</span>
                  </div>
                  <div class="product-result">
                      <span>{$value4}</span>
                  </div>
            </div>

            <div class="chart-info d-flex justify-content-between mb-1">
                  <div class="series-info d-flex align-items-center">
                      <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                      <span class="text-bold-600 ml-50">用户盈亏统计</span>
                  </div>
                  <div class="product-result">
                      <span>{$value2}</span>
                  </div>
                  <div class="product-result">
                      <span>{$value5}</span>
                  </div>
            </div>

            <div class="chart-info d-flex justify-content-between mb-1" >
                  <div class="series-info d-flex align-items-center">
                      <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                      <span class="text-bold-600 ml-50">总手续费</span>
                  </div>
                  <div class="product-result">
                      <span>{$value3}</span>
                  </div>
                  <div class="product-result">
                      <span>{$value6}</span>
                  </div>
            </div>
    </div>

    <a href="{$admin_url}/contract/contract-order?agent_id={$referrer}" class="btn btn-primary shadow waves-effect waves-light">View Details <i class="feather icon-chevrons-right"></i></a>
</div>
HTML
        );
    }
}
