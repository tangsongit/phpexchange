<?php

namespace App\Admin\Controllers;


use App\Admin\Renderable\UserTradeStatistics;
use App\Admin\Renderable\UserWalletExpand;
use App\Models\Agent;
use App\Models\SecondUser;
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

class SecondUserController extends AdminController
{
    protected $title = '秒合约用户管理';

    protected function grid()
    {
        $query = SecondUser::with(['user']);
        //return Grid::make($query, function (Grid $grid) use ($query) {
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->column('user_id', '用户ID');
            $grid->column('user.username', '用户名');
            $grid->column('referrer', '推荐人ID');
            $grid->column('pid', '父级ID');
            $grid->column('country_id', '国家代号');
            $grid->column('user.phone', '电话');
            $grid->column('user.email', '邮箱');
            $grid->column('invite_code', '邀请码');
            $grid->column('user.user_auth_level', '认证')->display(function ($val) {
                $txt = "未认证";
                if($val==1) $txt = '初级认证';
                if($val==2) $txt = '高级认证';
                return $txt;
            });
            $grid->column('is_system', '系统账户')->display(function ($val) {return $val?"是":"否";});
            $grid->column('user.status', '用户状态')->display(function ($val) {
                $txt = '<span class="label" style="background:#21b978">正常</span>';
                if($val==0) $txt = '<span class="label" style="background:#ea5455">冻结</span>';
                return $txt;
            });
            $grid->column('user.trade_status', '交易状态')->display(function ($val) {
                $txt = '<span class="label" style="background:#21b978">正常</span>';
                if($val==0) $txt = '<span class="label" style="background:#ea5455">冻结</span>';
                return $txt;
            });
            $grid->column('user.created_at', '创建时间');
            $grid->column('result_status', '管控状态')->select([0 => '默认',1 => '赢',2 => '输'], true);
            $grid->disableActions();
            $grid->showCreateButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new SecondUser(), function (Form $form) {
            $form->text('user_id', '用户id');
            $form->select('result_status', '管控状态')->options([0 => '默认',1 => '赢', 2 => '输']);
        });
    }
}
