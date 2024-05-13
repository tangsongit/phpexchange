<?php

namespace App\Admin\Metrics\Examples;

use App\Models\User;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Donut;

class NewDevices extends Donut
{
    protected $labels = ['今日注册量'];

    protected function init()
    {
        parent::init();

        $color = Admin::color();
        $colors = [$color->primary(), $color->alpha('blue2', 0.5)];

        $this->title('今日注册量(伞下)');
        $this->subTitle(date("Y-m-d H:i:s"));
        $this->content($this->day());
        // 设置图表颜色
        //$this->chartColors($colors);
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
        $this->withContents($this->day());

        // 图表数据
        $this->withChart([$this->day()]);
    }

    public function day()
    {
        $child_ids = collect(User::getChilds(Admin::user()->id))->pluck('user_id')->toArray();
        return User::query()
            ->whereIn('user_id', $child_ids)
            ->whereDate('created_at', Carbon::today())
            ->count();
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
    protected function withContent($desktop, $mobile = "")
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

    #下面重构的
    protected function withContents($desktop)
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

HTML
        );
    }
}
