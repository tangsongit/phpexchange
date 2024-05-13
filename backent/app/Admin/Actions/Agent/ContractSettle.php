<?php
/*
 * @Descripttion: 合约返佣手动结算
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-04 09:58:30
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-04 10:58:57
 */

namespace App\Admin\Actions\Agent;

use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Contract\ContractRebate;

class ContractSettle extends RowAction
{
    /**
     * @return string
     */
    protected $title = '结算';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        // dump($this->getKey());
        $rebate_log = ContractRebate::find($this->getKey());
        if ($rebate_log->settle()) {
            return $this->response()
                ->success('结算成功: ' . $this->getKey())
                ->refresh();
        } else {
            return $this->response()
                ->error('结算失败: ' . $this->getKey());
        }
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        return ['确定结算?', '每日12:00系统会自动结算，您可手动提前结算。'];
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        // 获取当前订单是否已结算
        return ContractRebate::find($this->getKey())->value('status') ? false : true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
