<?php

namespace App\Admin\Controllers\Finance;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\Coins;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\UserWalletLog;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Admin;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

class UserWalletLogController extends AdminController
{
    public function statistics($query)
    {
        $res1 = $query->sum('amount');
        $con = '<code>' . '总金额：' . $res1 . '</code> ';
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
        $query = UserWalletLog::with(['user'])
            ->where('user_wallet_logs.rich_type', 'usable_balance')
            ->whereIn('user_id', $base_ids);
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->model()->orderByDesc('id');
            $grid->withBorder();
            $grid->disableCreateButton();
            $grid->disableBatchDelete();
            $grid->disableActions();

            // xlsx
            $titles = ['id' => 'ID', 'user_id' => 'UID', 'username' => '用户名', 'referrer_name' => '代理', 'account_type' => '账户类型', 'log_type' => '流水类型', 'coin_name' => '币种', 'amount' => '金额', 'before_balance' => '原资产', 'after_balance' => '现资产', 'created_at' => '时间'];
            $grid->export();

            #统计
            $grid->header(function () use ($grid, $query) {
                $grid->model()->getQueries()->unique()->each(function ($value) use ($query) {
                    if (in_array($value['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) return;
                    call_user_func_array([$query, $value['method']], $value['arguments'] ?? []);
                });
                return $this->statistics($query);
            });

            $grid->column('user_id', '用户UID');
            $grid->column('user.username', '用户名');
            $grid->column('user.pid', '邀请人UID');
            $grid->column('user.referrer', Admin::user()->roles[0]->name . 'UID');
            $grid->column('account_type', '资产类型')->using(UserWalletLog::$accountTypeMap)->label([1 => 'green', 2 => 'blue']);
            $grid->column('log_type_text', '流水类型');
            $grid->coin_name;
            $grid->amount->display(function ($amount) {
                if ($amount < 0) {
                    return "<span style='color:red'>$amount</span>";
                } else {
                    return "<span style='color:green'>$amount</span>";
                }
            });
            //            $grid->log_note;
            $grid->before_balance;
            $grid->after_balance;
            $grid->created_at->sortable();
            //            $grid->updated_at->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('created_at', "时间")->datetime();
                $filter->where('search', function ($query) {
                    $query->whereHas('user', function ($q) {
                        $q->where('username', '=', "$this->input")
                            ->orWhere('phone', '=', "$this->input")
                            ->orWhere('account', '=', "$this->input");
                    });
                }, '用户名/手机')->width(3);

                $filter->in('log_type')->multipleSelect(UserWalletLog::$logType)->width(3);
                $filter->equal('account_type', '资产类型')->select(UserWalletLog::$accountTypeMap)->width(3);
                $filter->in('coin_id', '币种')->multipleSelect(Coins::getCachedCoinOption())->width(3);
                $filter->equal('user.referrer', Admin::user()->roles[0]->name . 'UID')->width(3);
                $filter->where('agent_id', function ($query) {
                    $referrer = $this->input;
                    $childs = collect(get_childs($referrer))->pluck('user_id')->toArray();
                    $query->whereIn('user_id', $childs);
                }, '链上查询')->placeholder(Admin::user()->roles[0]->name . 'UID')->width(3);
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
        return Show::make($id, new UserWalletLog(), function (Show $show) {
            $show->id;
            $show->user_id;
            $show->account_type;
            $show->coin_name;
            $show->rich_type;
            $show->amount;
            $show->log_type;
            $show->log_note;
            $show->before_balance;
            $show->after_balance;
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
        return Form::make(new UserWalletLog(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('account_type');
            $form->text('coin_name');
            $form->text('rich_type');
            $form->text('amount');
            $form->text('log_type');
            $form->text('log_note');
            $form->text('before_balance');
            $form->text('after_balance');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
