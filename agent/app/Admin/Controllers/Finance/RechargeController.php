<?php

namespace App\Admin\Controllers\Finance;

use App\Admin\Actions\Recharge\Pass;
use App\Admin\Forms\Recharge\Check;
use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\Coins;
use App\Models\Recharge;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;
use Illuminate\Support\Facades\Cache;

class RechargeController extends AdminController
{

    public function statistics($query)
    {
        // 统计总单
        $total = $query->count();
        global $con;
        $con = "<code>总单数： $total </code>";

        $query
            ->where('status', Recharge::status_pass)
            ->get()
            ->groupBy('coin_name')
            ->each(function ($v, $k) {
                global $con;
                $con .= "<code> {$k}金额：" . $v->sum('amount') . "</code>";
            });
        return Alert::make($con, '统计')->info();
    }

    #充币记录
    protected function grid()
    {
        $user_id = Admin::user()->id;
        $base_ids = collect(get_childs($user_id))->pluck('user_id')->toArray();
        $base_ids[] = $user_id;
        $sql = Recharge::query()->with(['user'])->whereHas("user", function ($query) use ($base_ids) {
            $query->whereIn('user_id', $base_ids);
        });
        return Grid::make($sql, function (Grid $grid) use ($sql) {
            $grid->withBorder();
            // xlsx
            $titles = ['id' => 'ID', 'user_id' => 'UID', 'username' => '用户名', 'referrer_name' => '代理', 'coin_name' => '币名', 'amount' => '金额', 'address' => '充币地址', 'datetime' => '时间', 'status' => '状态'];
            $grid->export();
            $grid->model()->orderByDesc('id');
            $grid->header(function () use ($grid, $sql) {
                $query = $sql;
                $grid->model()->getQueries()->unique()->each(function ($value) use ($query) {
                    if (in_array($value['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) return;
                    call_user_func_array([$query, $value['method']], $value['arguments'] ?? []);
                });
                return $this->statistics($query);
            });
            $grid->setActionClass(Grid\Displayers\Actions::class);

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableView();
            });
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableEditButton();

            $grid->column('user_id', '用户UID')->link(function ($value) { //点击查看用户详细资料
                return admin_url('user/team-list', $value);
            });
            $grid->column('username', '用户名');
            $grid->column('user.referrer', Admin::user()->roles[0]->name . "UID")->help('充值用户的上级' . Admin::user()->roles[0]->name . '<br>(0表示无上级' . Admin::user()->roles[0]->name . ')');
            $grid->column('coin_name', '币种');
            $grid->column('amount', '充币数量');

            $grid->status->using(Recharge::$statusMap)->dot([0 => 'danger', 1 => 'success', 2 => 'primary'])->filter(
                Grid\Column\Filter\In::make(Recharge::$statusMap)
            );
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
            $grid->column('datetime', '时间')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('datetime')->datetime();
                $filter->equal('user_id', '用户UID')->width(3);
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
                }, '链上查询')->placeholder('输入用户UID查询该用户伞下用户充值记录')->width(3);
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
        return Show::make($id, new Recharge(), function (Show $show) {
            $show->id;
            $show->user_id;
            $show->username;
            //            $show->coin_id;
            $show->coin_name;
            $show->collection_wallet;
            $show->datetime;
            $show->amount;
            $show->status;
            $show->address;
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
        return Form::make(new Recharge(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('username');
            $form->text('coin_id');
            $form->text('coin_name');
            //$form->text('collection_wallet');
            $form->text('datetime');
            $form->text('amount');
            $form->text('status');
            $form->text('address');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
