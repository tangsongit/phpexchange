<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 19:49:28
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-13 17:58:52
 */


namespace App\Admin\Renderable;


use App\Models\UserWallet;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Support\LazyRenderable;
use App\Admin\Metrics\User as UserCard;
use App\Models\Otc\OtcAccount;
use App\Models\SustainableAccount;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Table;

class UserWalletExpand extends LazyRenderable
{

    public function render()
    {
        $id = $this->key;
        return
            Table::make(['UID(合约账户)', '币种', '可用', '持仓', '委托冻结'], SustainableAccount::getUserWallet($id)) .
            Table::make(['UID(OTC账户)', '币种', '可用', '冻结'], OtcAccount::getUserWallet($id)) .
            Table::make(['UID(基本账户)', '币种', '可用', '冻结'], UserWallet::getUserWallet($id));
    }
}
