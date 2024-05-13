<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Withdraw\Check;
use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\Withdraw;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
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

        $query
            ->where('status', Withdraw::status_pass)
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
        $query = Withdraw::with(['user', 'user_auth']);
        return Grid::make($query, function (Grid $grid) use ($query) {
            #统计
            $grid->header(function () use ($grid, $query) {
                $grid->model()->getQueries()->unique()->each(function ($v) use ($query) {
                    if (in_array($v['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) return;
                    call_user_func_array([$query, $v['method']], $v['arguments'] ?? []);
                });
                return $this->statistics($query);
            });

            $grid->model()->orderByRaw("FIELD(status," . implode(",", array_keys(Withdraw::$statusMap)) . ")")->orderByDesc('id');
            $grid->setActionClass(Grid\Displayers\Actions::class);

            // xlsx
            $titles = ['id' => 'ID', 'user_id' => 'UID', 'username' => '用户名', 'coin_name' => '币名', 'amount' => '金额', 'address' => '充币地址', 'datetime' => '时间', 'status' => '状态'];
            $grid->export()->titles($titles)->rows(function (array $rows) use ($titles) {
                foreach ($rows as $index => &$row) {
                    $row['datetime'] = date('Y-m-d H:i:s', $row['datetime']);
                    $row['status'] = Withdraw::$statusMap[$row['status']];
                }
                return $rows;
            })->xlsx();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableQuickEdit();
                $actions->disableEdit();
                $actions->disableView();

                if ($actions->row->status == Withdraw::status_wait) {
                    $actions->append(new Check());
                }
            });

            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableEditButton();

            $grid->id->sortable();
            $grid->user_id;
            $grid->username;
            $grid->column('user_auth.realname', '姓名');
            // $grid->column('user.referrer',$grades[$lk])->display(function($v){
            //     return Agent::query()->where('id',$v)->value('name');
            // });

            $grid->coin_name;
            $grid->address;
            $grid->column('total_amount', '提币数量');
            $grid->column('amount', '实际到账数量');
            $grid->column("withdrawal_fee", "手续费")->display(function ($v) {
                return in_array($this->status, [
                    Withdraw::status_canceled,
                    Withdraw::status_failed,
                    Withdraw::status_reject
                ]) ? 0 : $v;
            });
            //            $grid->coin_id;
            $grid->datetime->display(function ($datetime) {
                return date('Y-m-d H:i:s', $datetime);
            });

            $grid->status->using(Withdraw::$statusMap)->dot([0 => 'danger', 1 => 'success', 2 => 'primary', 3 => 'info'])->filter(
                Grid\Column\Filter\In::make(Withdraw::$statusMap)
            );

            $grid->filter(function (Grid\Filter $filter) {

                $filter->whereBetween('datetime', function ($q) {
                    $start = strtotime($this->input['start']);
                    $end = strtotime($this->input['end']);
                    $q->whereBetween('datetime', [$start, $end + 86399]);
                })->date()->width(4);

                $filter->equal('user_id', 'UID')->width(2);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(2);
                $filter->equal('status', '状态')->select(Withdraw::$statusMap)->width(2);
                $filter->equal('coin_name')->width(2);
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
