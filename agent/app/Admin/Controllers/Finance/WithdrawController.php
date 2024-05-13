<?php

namespace App\Admin\Controllers\Finance;

use App\Admin\Actions\Withdraw\Check;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\Coins;
use App\Models\User;
use App\Models\Withdraw;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Http\Controllers\Api\V1\AgentController;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;
use Illuminate\Support\Facades\Cache;


class WithdrawController extends AdminController
{
    public function statistics($query)
    {
        // 统计总单
        $total = $query->count();
        global $con;
        $con = "<code>总单数： $total </code>";

        $total_success = $query->where('status', Withdraw::status_success)->count();
        $con .= "<code>提现成功单数： $total_success </code>";
        $query
            ->where('status', Withdraw::status_success)
            ->get()
            ->groupBy('coin_name')
            ->each(function ($v, $k) {
                global $con;
                $con .= "<code> {$k}金额：" . $v->sum('amount') . "</code>";
            });
        return Alert::make($con, '统计')->info();
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $user_id = Admin::user()->id;
        $base_ids = collect(get_childs($user_id))->pluck('user_id')->toArray();
        $base_ids[] = $user_id;
        $sql = Withdraw::query()->with(['user'])->whereHas("user", function ($query) use ($base_ids) {
            $query->whereIn('user_id', $base_ids);
        });
        return Grid::make($sql, function (Grid $grid) use ($sql) {
            $grid->withBorder();
            // xlsx
            $titles = ['id' => 'ID', 'user_id' => 'UID', 'username' => '用户名', 'referrer_name' => Admin::user()->roles[0]->name, 'coin_name' => '币名', 'amount' => '金额', 'address' => '充币地址', 'datetime' => '时间', 'status' => '状态'];
            $grid->export();

            #统计
            $grid->header(function () use ($grid, $sql) {
                $query = $sql;
                $grid->model()->getQueries()->unique()->each(function ($v) use ($query) {
                    if (in_array($v['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) return;
                    call_user_func_array([$query, $v['method']], $v['arguments'] ?? []);
                });
                return $this->statistics($query);
            });

            $grid->model()->orderByDesc('id');
            $grid->setActionClass(Grid\Displayers\Actions::class);

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableQuickEdit();
                $actions->disableEdit();
                $actions->disableView();

                // if ($actions->row->status == Withdraw::status_wait) {
                //     $actions->append(new Check());
                // }
            });
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableEditButton();

            $grid->column('user_id', '用户UID')->link(function ($value) { //点击查看用户详细资料
                return admin_url('user/team-list', $value);
            });
            $grid->column('username', '用户名');
            $grid->column('user.referrer', Admin::user()->roles[0]->name . 'UID')->help('充值用户的' . Admin::user()->roles[0]->name . 'UID<br>(0表示无上级代理)');
            $grid->column('coin_name', '币种名称');
            $grid->column('total_amount', '提币数量');
            $grid->column('amount', '实际到账数量')->help('扣除手续费后的数量');
            $grid->column("withdrawal_fee", "手续费")->display(function ($v) {
                return in_array($this->status, [
                    Withdraw::status_canceled,
                    Withdraw::status_failed,
                    Withdraw::status_reject
                ]) ? 0 : $v;
            });
            $grid->column('lead', '用户所属')->display(function ($v) {
                $parents = '';
                $parent_arr = \App\Models\User::getParentUsers($this->user_id)->reject(function ($user) {
                    return ($user->is_agency == 0 && $user->is_place == 0) ? 1 : 0;
                });
                foreach ($parent_arr as $v) {
                    $name = \App\Models\AgentUser::find($v->user_id)->remark ?? $v->username;
                    if ($name) {
                        $parents .= $name . '/';
                    }
                    if ($v->user_id == Admin::user()->id) break;
                }
                return substr($parents, 0, -1);
            })->limit(15)->help('用户所属渠道/代理商，以合伙人备注显示');
            $grid->column('datetime', '提币时间');

            $grid->status->using(Withdraw::$statusMap)->dot([0 => 'danger', 1 => 'success', 2 => 'primary', 3 => 'info'])->filter(
                Grid\Column\Filter\In::make(Withdraw::$statusMap)
            );
            //            $grid->column("withdrawal_price","提币价");

            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('datetime')->datetime();
                $filter->equal('user_id', 'UID')->width(3);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(3);
                $filter->equal('coin_name')->width(3);
                $filter->equal('user.referrer', Admin::user()->roles[0]->name . 'UID')->width(3);
                $filter->where('agent_id', function ($query) {
                    $base_ids = collect(User::getChilds($this->input))->pluck('user_id');
                    $query->whereIn('user_id', $base_ids);
                }, '链上查询')->placeholder('输入代理UID查询该代理伞下用户充值记录')->width(3);
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Withdraw(), function (Show $show) {
            $show->id;
            $show->user_id;
            $show->username;
            $show->amount;
            $show->status;
            $show->coin_id;
            $show->coin_name;
            $show->address;
            $show->datetime;
            $show->agent_level;
            $show->agent_name;
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
        return Form::make(new Withdraw(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('username');
            $form->text('amount');
            $form->text('status');
            $form->text('coin_id');
            $form->text('coin_name');
            $form->text('address');
            $form->text('datetime');
            $form->text('agent_level');
            $form->text('agent_name');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
