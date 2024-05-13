<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/29
 * Time: 19:11
 */

namespace App\Admin\Controllers\Finance;

use App\Models\Agent;
use App\Models\AgentGrade;
use App\Models\Coins;
use App\Models\User;
use App\Models\UserWallet;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

class UserAssetsController extends AdminController
{

    public function statistics($query)
    {
        global $con;
        $query->get(['coin_name', 'usable_balance', 'freeze_balance'])
            ->groupBy('coin_name')
            ->each(function ($v, $k) {
                // 资产 = 可用资产 + 冻结资产
                global $con;
                $con .= "<code>{$k}资产：" . ($v->sum('usable_balance') + $v->sum('freeze_balance')) . '</code>&nbsp;';
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
        $query = UserWallet::with(['user'])->whereIn('user_id', $base_ids);
        return Grid::make($query, function (Grid $grid) use ($query) {
            $grid->model()->orderByDesc('usable_balance');
            $grid->withBorder();
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableRowSelector();

            $grid->header(function () use ($grid, $query) {
                $grid->model()->getQueries()->unique()->each(function ($v) use ($query) {
                    if (in_array($v['method'], ['paginate', 'get', 'orderBy', 'orderByDesc'])) return;
                    call_user_func_array([$query, $v['method']], $v['arguments'] ?? []);
                });
                return $this->statistics($query);
            });
            $grid->export();

            $grid->column('user_id', '用户UID')->link(function ($value) { //点击查看用户详细资料
                return admin_url('user/team-list', $value);
            })->sortable();
            $grid->column('user.username', '用户名');
            $grid->column('user.referrer', Admin::user()->roles[0]->name . 'UID');
            $grid->column('identity', '身份')->display(function () {
                if ($this->user['is_agency'] == 1) $iden[] = '代理商';
                if ($this->user['is_place'] == 1) $iden[] = '渠道商';
                if (!isset($iden)) {
                    return '普通用户';
                }
                return $iden ?? [];
            })->label();
            $grid->coin_name;
            $grid->usable_balance->sortable();
            $grid->freeze_balance->sortable();
            $grid->disableCreateButton();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('created_at', "时间")->datetime();
                $filter->equal('user_id', '用户UID')->width(3);
                $filter->where('username', function ($q) {
                    $username = $this->input;
                    $q->whereHas('user', function ($q) use ($username) {
                        $q->where('username', $username)->orWhere('phone', $username)->orWhere('email', $username);
                    });
                }, "用户名/手机/邮箱")->width(3);
                $filter->equal('coin_id', '币种')->select(Coins::getCachedCoinOption())->width(3);
                $filter->equal('user.referrer', Admin::user()->roles[0]->name . 'UID')->width(3);
                $filter->where('agent_id', function ($query) {
                    $referrer = $this->input;
                    $childs = collect(get_childs($referrer))->pluck('user_id')->toArray();
                    $query->whereIn('user_id', $childs);
                }, '链上查询')->placeholder(Admin::user()->roles[0]->name . 'UID')->width(3);
                $filter->where('is_agency', function ($query) {
                    $is_agency = $this->input;
                    if ($is_agency == 1) {
                        $query->whereHas('user', function ($query) {
                            $query->where('is_agency', 1);
                        });
                    } elseif ($is_agency == 2) {
                        $query->whereHas('user', function ($query) {
                            $query->where('is_place', 1);
                        });
                    } elseif ($is_agency == 0) {
                        $query->whereHas('user', function ($query) {
                            $query->where('is_agency', 0);
                            $query->where('is_place', 0);
                        });
                    }
                }, '用户身份')->select([0 => '普通用户', 1 => '代理商', 2 => '渠道商'])->width(3);
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
        return Show::make($id, new UserWallet(), function (Show $show) {
            // 这里的字段会自动使用翻译文件
            $show->id;
            $show->coin_name;
            $show->address;
            $show->usable_balance;
            $show->freeze_balance;
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
        return Form::make(new UserWallet(), function (Form $form) {
            // 这里的字段会自动使用翻译文件
            $form->display('id');
            $form->text('coin_name');
            $form->text('usable_balance');
            $form->text('freeze_balance');


            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
