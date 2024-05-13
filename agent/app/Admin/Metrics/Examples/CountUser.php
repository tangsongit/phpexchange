<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-28 15:28:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 16:56:18
 */

namespace App\Admin\Metrics\Examples;

use App\Models\Agent;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;

class CountUser extends Line
{

    //protected $labels = ['总注册'];

    //--------------------重构
    protected function init()
    {
        parent::init();
        $color = Admin::color();
        $colors = [$color->primary(), $color->alpha('blue2', 0.5)];
        $this->title('总注册数（伞下）');
        $this->subTitle(date("Y-m-d H:i:s"));
        //$this->chartLabels($this->labels);
        // 设置图表颜色
        $this->chartColors($colors);
    }

    //*******************************************


    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */

    public function handle(Request $request)
    {
        $childs = User::getChilds(Admin::user()->id);

        $user_count = count($childs);
        $agent_count = collect($childs)->where('is_agency', 1)->count();
        $this->withContent($agent_count, $user_count);
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
            'series' => [
                [
                    'name' => $this->title,
                    'data' => $data,
                ],
            ],
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content, $contents)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h4 class="ml-1 font-lg-1">代理：{$content}</h4>
    <h4 class="ml-1 font-lg-1">用户：{$contents}</h4>
    <span class="mb-0 mr-1 "></span>
</div>
HTML
        );
    }
}
