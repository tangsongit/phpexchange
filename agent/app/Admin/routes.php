<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-28 15:28:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-28 17:05:01
 */

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('users', 'PersonController'); #个人中心
    $router->get('api/agents', 'UserController@agents');

    // 代理中心
    Route::prefix('agent')->group(function (Router $route) {
        $route->resource('list', 'Agent\AgentListController'); #代理列表
        $route->resource('contract-rebate', 'Contract\RebateController'); //代理返佣记录
    });
    // 渠道商专属（查看盈亏）
    Route::prefix('place')->group(function (Router $route) {
        $route->resource('contract-entrust-profit', 'Contract\ContractEntrustProfitController'); //合约订单盈亏
        $route->resource('place-list', 'Place\PlaceListController'); //渠道商列表
        $route->resource('place-tree', 'Place\PlaceTreeController'); //渠道商列表树
    });
    // 用户列表
    Route::prefix('user')->group(function (Router $route) {
        $route->resource('user-list', 'User\UserListController'); //直推用户列表
        $route->resource('team-list', 'User\TeamListController'); //直推用户列表
    });

    // 财务管理
    Route::prefix('finance')->group(function (Router $route) {
        $route->resource('recharge', 'Finance\RechargeController'); //用户充币记录 
        $route->resource('withdraw', 'Finance\WithdrawController'); //用户提币记录
        $route->resource('transfer', 'Finance\UserTransferRecordController'); //用户划转记录
        $route->resource('user-assets', 'Finance\UserAssetsController'); //用户资产
        $route->resource('user-wallet-log', 'Finance\UserWalletLogController'); #资产流水
        $route->resource('otc-account', 'Finance\OtcAccountController'); //法币账户
        $route->resource('otc-order', 'Finance\OtcOrderController'); //法币订单
    });

    // 期权管理
    Route::prefix('option')->group(function (Router $route) {
        $route->resource('option-order', 'Option\OptionSceneOrderController'); //期权订单
    });

    // 合约交易
    Route::prefix('contract')->group(function (Router $route) {
        $route->resource('contract-entrust', 'Contract\ContractEntrustController'); //合约委托
        $route->resource('contract-position', 'Contract\ContractPositionController'); //合约持仓记录
        $route->resource('contract-wear-position-record', 'Contract\ContractWearPositionRecordController'); // 合约穿仓记录
        $route->resource('contract-account', 'Contract\ContractAccountController'); // 永续合约账户
        $route->resource('subscribe-settlement', 'Contract\SubscribeSettlementController'); // 申购结算
        $route->resource('contract-purchase', 'Contract\PurchaseController'); // 申购记录
        $route->resource('contract-order', 'Contract\ContractOrderController'); // 永续合约成交记录

    });
    // 币币交易
    Route::prefix('exchange')->group(function (Router $route) {
        $route->resource('trade-buy', 'Exchange\InsideTradeBuyController'); //币币买入委托
        $route->resource('trade-sell', 'Exchange\InsideTradeSellController'); //币币卖出委托
        $route->resource('trade-order', 'Exchange\InsideTradeOrderController'); //币币成交记录
    });


    $router->resource('contract-settlement', 'ContractSettlementController'); // 合约结算
    $router->resource('option-settlement', 'OptionSettlementController'); // 期权结算
    $router->resource('performance', 'PerformanceController'); // 代理业绩
});
