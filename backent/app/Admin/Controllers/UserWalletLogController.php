<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-09-06 10:51:25
 */

namespace App\Admin\Controllers;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\Coins;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\UserWalletLog;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
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
        $query = UserWalletLog::query()->with(['user']);
        // ->where('user_wallet_logs.rich_type', 'usable_balance');
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->model()->orderByDesc('id');
            $grid->disableCreateButton();
            $grid->disableBatchDelete();
            $grid->disableActions();

            #统计
            $grid->header(function () use ($grid, $query) {
                $query = $query;
                $grid->model()->getQueries()->unique()->each(function ($value) use ($query) {
                    if (in_array($value['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'], true)) return;
                    call_user_func_array([$query, $value['method']], $value['arguments'] ?? []);
                });
                return $this->statistics($query);
            });

            // xlsx
            $titles = ['id' => 'ID', 'user_id' => 'UID', 'username' => '用户名', 'account_type' => '账户类型', 'rich_type' => '资产类型', 'log_type' => '流水类型', 'coin_name' => '币种', 'amount' => '金额', 'before_balance' => '原资产', 'after_balance' => '现资产', 'created_at' => '时间'];
            $grid->export()->titles($titles)->rows(function (array $rows) use ($titles) {
                foreach ($rows as $index => &$row) {
                    $row['username'] = $row['user']['username'];
                    $account_type = $row['account_type'];
                    $account = array_first(UserWallet::$accountMap, function ($value, $key) use ($account_type) {
                        return $value['id'] == $account_type;
                    });
                    $row['account_type'] = blank($account) ? '--' : $account['name'];
                    $row['log_type'] = UserWalletLog::getLogTypeText($row['log_type']);
                    $row['rich_type'] = UserWallet::$richMap[$row['rich_type']];
                }
                return $rows;
            })->xlsx();

            $grid->id->sortable();
            $grid->account_type->display(function ($v) {
                return  collect(UserWallet::$accountMap)->pluck('name', 'id')[$v];
            })->label()->filter(
                Grid\Column\Filter\In::make(collect(UserWallet::$accountMap)->pluck('name', 'id')->toArray())
            );
            $grid->column('rich_type')->using(UserWallet::$richMap)->label()->filter(
                Grid\Column\Filter\In::make(UserWallet::$richMap)
            );
            $grid->user_id->sortable();
            $grid->column('user.username', '用户名');

            $grid->log_type->display(function ($v) {
                return UserWalletLog::getLogTypeText($v);
            });
            $grid->coin_name;
            //            $grid->rich_type;
            $grid->amount->display(function ($amount) {
                if ($amount < 0) {
                    return "<span style='color:red'>$amount</span>";
                } else {
                    return "<span style='color:green'>$amount</span>";
                }
            });
            //            $grid->log_note;
            $grid->before_balance->sortable();
            $grid->after_balance->sortable();
            $grid->created_at->sortable();
            //            $grid->updated_at->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('user_id', 'UID')->width(2);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(3);
                $filter->in('log_type')->multipleSelect(UserWalletLog::$logType)->width(3);
                $filter->in('coin_id', '币种')->multipleSelect(Coins::getCachedCoinOption())->width(3);
                $filter->between('created_at', "时间")->datetime()->width(4);
                $filter->where('agent_id', function ($query) {
                    $referrer = $this->input;
                    $childs = collect(get_childs($referrer))->pluck('user_id')->toArray();
                    $query->whereIn('user_id', $childs);
                }, '链上查询')->placeholder('代理商UID')->width(3);
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
