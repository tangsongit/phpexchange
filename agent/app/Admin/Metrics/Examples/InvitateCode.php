<?php

namespace App\Admin\Metrics\Examples;

use App\Models\Agent;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;

class InvitateCode extends Line
{

    //protected $labels = ['邀请地址'];

    //--------------------重构
    protected function init()
    {
        parent::init();
        $color = Admin::color();
        $colors = [$color->primary(), $color->alpha('blue2', 0.5)];
        $this->title('邀请地址');
        $invite_code = User::find(Admin::user()->id)->invite_code;
        $address_pc = config("app.pc_invite_url") . $invite_code;
        $address_mobile = config("app.h5_invite_url") . $invite_code;
        $this->content =  "<a href=\"$address_pc\">$address_pc</a> <br> <a href=\"$address_mobile\">$address_mobile</a>";
        $this->subTitle(date("Y-m-d H:i:s"));
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
        $generator = function ($len, $min = 10, $max = 300) {
            for ($i = 0; $i <= $len; $i++) {
                yield mt_rand($min, $max);
            }
        };

        switch ($request->get('option')) {
            case '365':
                // 卡片内容
                $this->withContent(mt_rand(1000, 5000) . 'k');
                // 图表数据
                $this->withChart(collect($generator(30))->toArray());
                break;
            case '30':
                // 卡片内容
                $this->withContent(mt_rand(400, 1000) . 'k');
                // 图表数据
                $this->withChart(collect($generator(30))->toArray());
                break;
            case '28':
                // 卡片内容
                $this->withContent(mt_rand(400, 1000) . 'k');
                // 图表数据
                $this->withChart(collect($generator(28))->toArray());
                break;
            case '7':
            default:
                // 卡片内容
                $this->withContent($this->count());
                // 图表数据
                /* $this->withChart([28, 40, 36, 52, 38, 60, 55,]);*/
        }
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
    <h4 class="ml-1 font-lg-1"><a href="#">{$this->content}</a></h4>
    <span class="mb-0 mr-1 "></span>
</div>
HTML
        );
    }
}
