<?php

namespace App\Admin\Controllers;


use App\Admin\Renderable\UserTradeStatistics;
use App\Admin\Renderable\UserWalletExpand;
use App\Models\Agent;
use App\Models\SecondConfig;
use App\Models\AgentGrade;
use App\Models\Country;
use App\Models\User;
use App\Models\UserGrade;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Admin\Actions\User\AddSystemUser;
use App\Admin\Actions\User\AddUser;
use App\Admin\Renderable\Parents;

class SecondConfigController extends AdminController
{
    protected $title = '秒合约配置管理';

    protected function grid()
    {
        return Grid::make(new SecondConfig(), function (Grid $grid) {
            
            $grid->toolsWithOutline();
            $grid->column('seconds', '秒数');
            $grid->column('profit_rate', '收益率');
            $grid->column('loss_rate', '亏损率');
            $grid->column('charge_rate', '手续费率');
            $grid->column('min_amount', '最低起投');
            $grid->status('状态')->switch();
            //$grid->enableDialogCreate(); // 启用弹窗创建
            $grid->disableViewButton();
            $grid->showCreateButton();
            $grid->showEditButton();
            $grid->showDeleteButton();
            // $grid->disableBatchDelete();
           
            //$grid->option("dialog_form_area", ["70%", "80%"]);
        });
    }
    
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new SecondConfig(), function (Form $form) {
            $form->text('seconds', '秒数');
            $form->text('profit_rate', '收益率');
            $form->text('loss_rate', '亏损率');
            $form->text('charge_rate', '手续费率');
            $form->text('min_amount', '最低起投');
            $form->switch('status');
        });
    }
}
