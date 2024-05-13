<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-05 11:35:45
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-07 00:58:42
 */

namespace App\Admin\Actions\Place;

use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AgentUser;
use Illuminate\Support\Facades\DB;

class DeletePlace extends RowAction
{
    /**
     * @return string
     */
    protected $title = '删除渠道商';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        try {
            DB::beginTransaction();
            $user_id = $this->getKey();
            $user = User::find($user_id);
            // 1、更新用户渠道商状态
            $user->update(['is_place' => 0]);
            // 2、删除用户登录渠道商后台权限
            DB::table('agent_admin_role_users')
                ->where(['user_id' => $user_id, 'role_id' => 3])
                ->delete();
            // 3、查询用户是否是代理商、如果不是 删除userAgent表中的代理信息
            if ($user->is_agency == 0) {
                AgentUser::query()
                    ->where('id', $user_id)
                    ->delete();
            }
            DB::commit();
            return $this->response()
                ->success('删除成功: ' . $this->getKey())
                ->refresh();
        } catch (\Exception $e) {
            info($e);
            return $this->response()
                ->error('删除失败');
        }

        return $this->response()
            ->success('删除成功: ' . $this->getKey())
            ->refresh();
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        return ['确定删除该用户渠道商权限?', '删除之后，若用户为代理商仍可登录代理商后台，但无法查看渠道商菜单'];
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        // 判断该用户是否是渠道商

        return (User::find($this->getKey())->is_place == 1) ? true : false;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }

    public function html()
    {

        $this->appendHtmlAttribute('class', 'btn btn-outline-primary btn-sm btn-mini submit');
        return parent::html();
    }
}
