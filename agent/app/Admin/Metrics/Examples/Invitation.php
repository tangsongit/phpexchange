<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-28 15:28:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 15:31:56
 */

namespace App\Admin\Metrics\Examples;

use App\Models\Agent;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;

class Invitation extends Line
{

    //protected $labels = ['邀请地址'];
    //--------------------重构
    protected function init()
    {
        parent::init();
        $color = Admin::color();
        $colors = [$color->primary(), $color->alpha('blue2', 0.5)];
        $this->title('邀请码');
        //$user = User::find(Admin::user()->id);
        //if( Admin::user()->deep ==4 ){
        $invite_code = User::find(Admin::user()->id)->invite_code;
        $this->content = $invite_code;


        $this->subTitle(date("Y-m-d H:i:s"));
        //$this->chartLabels($this->labels);
        // 设置图表颜色
        $this->chartColors($colors);
    }

    public function  count()
    {
        $agent = new \App\Http\Controllers\Api\V1\AgentController();
        $next = $agent->getUser(Admin::user()->id);
        return count($next);
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
        // 卡片内容
        $this->withContent($this->count());
        // 图表数据
        /* $this->withChart([28, 40, 36, 52, 38, 60, 55,]);*/
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
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$this->content}</h2>
    <span class="mb-0 mr-1 "></span>
</div>
HTML
        );
    }
}
