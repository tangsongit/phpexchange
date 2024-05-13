<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-05 13:44:29
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-09-10 18:01:00
 */

namespace App\Admin\Actions\Agent;

use App\Models\User;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToBePlace extends RowAction
{
    /**
     * @return string
     */
    protected $title = '升为渠道商';


    public function canClick(bool $boolean)
    {
        $this->canClick = $boolean;
        return $this;
    }
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
            $user_id = $this->getKey();
            DB::beginTransaction();
            // 1、更新用户渠道商身份
            User::find($user_id)->update(['is_place' => 1]);
            // 2、绑定用户渠道商角色
            DB::table('agent_admin_role_users')->insertOrIgnore(['role_id' => 3, 'user_id' => $user_id]);
            DB::commit();
            return $this->response()
                ->success('升级成功')
                ->refresh();
        } catch (\Exception $e) {
            info($e);
            return $this->response()
                ->error('升级失败');
        }
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        return ['升级渠道商?', '升级后该代理可在代理商后台查看用户盈亏数据'];
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
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
        if (!$this->canClick) $this->appendHtmlAttribute('class', 'disabled');
        return parent::html();
    }
}
