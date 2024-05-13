<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-02 11:14:27
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-18 18:27:13
 */

namespace App\Admin\Actions\Agent;

use App\Models\AgentUser;
use App\Models\User;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteAgent extends RowAction
{
    /**
     * @return string
     */
    protected $title = '删除代理';

    /**
     * 执行删除代理操作
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        // 
        try {
            DB::beginTransaction();
            $user_id = $this->getKey();
            // 1、删除代理列表(如果该用户不为渠道商)
            if (User::query()
                ->where('user_id', $user_id)
                ->where('is_place', 0)
                ->first()
            ) {
                AgentUser::find($user_id)->delete();
            } else {
                AgentUser::find($user_id)->update(['rebate_rate' => null]);
            }
            // 2、去除代理权限
            DB::table('agent_admin_role_users')->where('user_id', $user_id)->delete();
            // 3、更新用户代理状态
            User::find($user_id)->update(['is_agency' => 0]);
            // 4、将下级代理的referrer改为0(如果代理商是当前用户的情况下)
            User::query()
                ->where('pid', $user_id)
                ->where('referrer', $user_id)
                ->update(['referrer' => 0]);
            // 5、发送通知给当前用户
            DB::commit();

            return $this->response()->success("删除代理UID：$user_id 成功")->refresh();
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return $this->response()->error('删除代理失败');
        }

        return $this->response()
            ->success('删除代理UID: ' . $this->getKey())
            ->refresh();
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        return ['确定删除?', '删除代理后，此用户从此刻起不再享受代理返佣权力，但是此刻之前发生的订单返利明日照常进行。'];
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        // 检查该代理是否属于该代理直属下级
        return blank(User::query()->where('user_id', $this->getKey())->where('pid', $user->user_id)) ? false : true;;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }

    /**
     * 设置HTML标签的属性
     *
     * @return void
     */
    protected function setupHtmlAttributes()
    {
        // 添加class
        $this->addHtmlClass('btn btn-sm btn-outline-primary nowrap');

        // 保存弹窗的ID
        // $this->setHtmlAttribute('data-target', '#' . $this->modalId);

        parent::setupHtmlAttributes();
    }
}
