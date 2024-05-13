<?php

namespace App\Admin\Metrics\Examples;

use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Donut;

class NewUsers extends Donut
{
    protected $labels = ['已认证', '未认证'];

    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $color = Admin::color();
        $colors = [$color->primary(), $color->alpha('blue2', 0.5)];

        $this->title('是否认证(伞下)');
        $this->subTitle(date("Y-m-d H:i:s"));
        $this->chartLabels($this->labels);
        // 设置图表颜色
        $this->chartColors($colors);
    }

    /**
     * 渲染模板
     *
     * @return string
     */
    public function render()
    {
        $this->fill();
        return parent::render();
    }

    /**
     * 写入数据.
     *
     * @return void
     */
    public function fill()
    {

        // 已认证人数
        $users = User::getChilds(Admin::user()->id);
        $authhated = collect($users)
            ->whereNotIn('user_auth_level', [0])
            ->count();
        $unauthorized = collect($users)
            ->where('user_auth_level', 0)
            ->count();
        #已认证
        $this->withContent($authhated, $unauthorized);

        // 图表数据
        $this->withChart([$authhated, $unauthorized]);
    }


    /// -------------------------------------------
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
            'series' => $data
        ]);
    }

    /**
     * 设置卡片头部内容.
     *
     * @param mixed $desktop
     * @param mixed $mobile
     *
     * @return $this
     */
    protected function withContent($desktop, $mobile)
    {
        $blue = Admin::color()->alpha('blue2', 0.5);

        $style = 'margin-bottom: 8px';
        $labelWidth = 120;

        return $this->content(
            <<<HTML
<div class="d-flex pl-1 pr-1 pt-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-primary"></i> {$this->labels[0]}
    </div>
    <div>{$desktop}</div>
</div>
<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle" style="color: $blue"></i> {$this->labels[1]}
    </div>
    <div>{$mobile}</div>
</div>
HTML
        );
    }
}
