<?php

namespace App\Admin\Controllers;


use App\Admin\Renderable\UserTradeStatistics;
use App\Admin\Renderable\UserWalletExpand;
use App\Models\Agent;
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
use App\Models\KuangjiOrder;
class KuangjOrderController extends AdminController
{
    protected $title = '矿机订单列表';

    protected function grid()
    {
        return Grid::make(KuangjiOrder::with(['coins','coink']), function (Grid $grid) {

          

          

            $grid->user_id;
            $grid->column('coins.coin_name', '质押币种');
            $grid->column('amount', '质押数量');
            $grid->column('coink.coin_name', '产出币种');
            $grid->column('Interest', '已获得利息');
            $grid->column('value_at', '起息日');
            $grid->column('end_at', '计息结束日');
            $grid->column('Interest', '已获得利息');
             $grid->column('status', '矿机状态')->display(function () {
                if ($this->status == 1) $iden[] = '未开始';
                if ($this->status == 2) $iden[] = '释放中';
                if ($this->status == 3) $iden[] = '释放完成';
                return $iden ?? [];
            })->label();
            $grid->created_at->sortable();
            $grid->disableViewButton();
            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->disableBatchDelete();

          
        });
    }

    // public function agents(Request $request)
    // {
    //     $q = $request->get('q');
    //     $options = Agent::query()->where(['pid' => $q, 'is_agency' => 1])->select(['id', 'username as text'])->get()->toArray();
    //     array_unshift($options, []);
    //     return $options;
    // }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new User(), function (Show $show) {
            $show->user_id;
            $show->account;
            $show->account_type;
            $show->username;
            $show->pid;
            $show->deep;
            $show->path;
            $show->country_code;
            $show->phone;
            $show->email;
            $show->avatar;
            $show->password;
            $show->payword;
            $show->invite_code;
            $show->user_grade;
            $show->user_identity;
            $show->user_auth_level;
            $show->login_code;
            $show->status;
            $show->reg_ip;
            $show->last_login_time;
            $show->last_login_ip;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new KuangjOrder(), function (Form $form) {

            $form->text('user_id')->readOnly();
            $form->text('username')->rules("required:users,username");
            $form->text('name');
            $form->switch('status');
            $form->switch('trade_status');
            $form->text('pid', "上级ID")->rules("required:users,pid");
            $form->text('referrer', "代理ID");
            $form->text('invite_code')->disable();
        });
    }
}
