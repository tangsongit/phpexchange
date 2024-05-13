<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Recharge\Pass;
use App\Admin\Forms\Recharge\Check;
use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\Recharge;
use App\Models\UserWallet;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
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

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $query = Recharge::with(['user', 'user_auth']);
        return Grid::make($query, function (Grid $grid) use ($query) {
            #统计
            $grid->header(function () use ($grid, $query) {
                $query = $query;
                $grid->model()->getQueries()->unique()->each(function ($value) use ($query) {
                    if (in_array($value['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) return;
                    call_user_func_array([$query, $value['method']], $value['arguments'] ?? []);
                });
                return $this->statistics($query);
            });

            $grid->model()->orderByRaw("FIELD(status," . implode(",", array_keys(Recharge::$statusMap)) . ")")->orderByDesc('id');

            // xlsx
            $titles = ['id' => 'ID', 'user_id' => 'UID', 'username' => '用户名', 'coin_name' => '币名', 'amount' => '金额', 'address' => '充币地址', 'datetime' => '时间', 'status' => '状态'];
            $grid->export()->titles($titles)->rows(function (array $rows) use ($titles) {
                foreach ($rows as $index => &$row) {
                    $row['datetime'] = date('Y-m-d H:i:s', $row['datetime']);
                    $row['status'] = Recharge::$statusMap[$row['status']];
                }
                return $rows;
            })->xlsx();

            $grid->setActionClass(Grid\Displayers\Actions::class);

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableQuickEdit();
                $actions->disableEdit();
                $actions->disableView();

                if ($actions->row->status == Recharge::status_wait) {
                    $actions->append(new Pass());
                }
            });

            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->disableBatchDelete();
            //            $grid->disableRowSelector();

            $grid->id->sortable();
            $grid->user_id;
            $grid->username;
            $grid->column('user_auth.realname', '姓名');

            //            $grid->coin_id;
            $grid->coin_name;
            $grid->amount->display(function ($v) {
                return custom_number_format($v, 8);
            });
            $grid->column('account_type', '账户类型')->using(UserWallet::$accountOptions)->label();
            //            $grid->collection_wallet;
            $grid->address->limit(20)->responsive();
            $grid->type->using(Recharge::$typeMap);
            $grid->note;
            $grid->datetime->display(function ($datetime) {
                return date('Y-m-d H:i:s', $datetime);
            });
            //            $grid->status->using(Recharge::$statusMap)->dot([0=>'danger',1=>'success',2=>'primary'])->filter(
            //                Grid\Column\Filter\In::make(Recharge::$statusMap)
            //            );

            $grid->filter(function (Grid\Filter $filter) {

                $filter->equal('coin_name')->width(2);
                $filter->whereBetween('datetime', function ($q) {
                    $start = !empty($this->input['start']) ? strtotime($this->input['start']) : null;
                    $end = !empty($this->input['end']) ? strtotime($this->input['end']) : null;
                    //                    dd($this->input['end'],$end);
                    $q->whereBetween('datetime', [$start, $end + 86399]);
                })->date()->width(4);
                $filter->equal('user_id', 'UID')->width(2);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(2);

                //                $filter->equal('status','状态')->select(Recharge::$statusMap)->width(2);
                $filter->equal('account_type', '账户类型')->select(UserWallet::$accountOptions)->width(2);
                $filter->equal('type', '充值类型')->select(Recharge::$typeMap)->width(2);
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
            $form->text('collection_wallet');
            $form->text('datetime');
            $form->text('amount');
            $form->text('status');
            $form->text('address');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
