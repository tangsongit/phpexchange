<?php

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

    $router->get('api/agents', 'UserController@agents');

    Route::prefix('agent')->group(function ($route) {
        $route->resource('contract-rebate', 'Contract\ContractRebateController');
    });
    $router->resource('users', 'UserController');
    $router->resource('user-auth', 'UserAuthController');
    $router->resource('user-assets', 'UserAssetsController');
    $router->resource('user-wallet-log', 'UserWalletLogController');
    $router->resource('asset-details', 'AssetDetailsController');
    $router->resource('user-grade', 'UserGradeController');

    $router->resource('article-category', 'ArticleCategoryController');
    $router->resource('article', 'ArticleController');

    $router->resource('banner', 'BannerController');

    $router->resource('option-pair', 'OptionPairController');
    $router->resource('option-time', 'OptionTimeController');
    $router->resource('listing-application', 'ListingApplicationController'); //上币申请
    $router->resource('subscription-Management', 'SubscriptionManagementController'); //申购管理
    $router->resource('subscribe-record', 'UserSubscribeRecordController'); //申购管理
    $router->resource('subscribe-activity', 'SubscribeActivityController'); //申购活动
    $router->resource('recharge', 'RechargeController'); //充值管理
    $router->resource('rechargeManual', 'RechargeManualController');
    $router->resource('deposit-address', 'DepositAddressController'); //充币地址列表
    $router->resource('payment-method', 'PaymentMethodController'); //收款账户列表
    $router->resource('withdraw', 'WithdrawController');
    $router->resource('option-order', 'OptionSceneOrderController'); //期权订单
    $router->resource('bonus-log', 'BonusLogController'); //期权佣金
    $router->resource('bonus-log-statistics', 'BonusLogStatisticsController'); //期权佣金统计
    $router->resource('option-scene', 'OptionSceneController'); //期权场景
    $router->resource('advice', 'AdviceController');
    $router->resource('Agent', 'AgentController'); //代理商列表
    $router->resource('agent-grade', 'AgentGradeController'); //代理商级别

    $router->resource('coin', 'CoinController');
    $router->resource('inside-trade-pair', 'InsideTradePairController');
    $router->resource('inside-trade-buy', 'InsideTradeBuyController');
    $router->resource('inside-trade-sell', 'InsideTradeSellController');
    $router->resource('inside-trade-order', 'InsideTradeOrderController');

    $router->resource('admin-setting', 'AdminSettingController');
    $router->resource('translates', 'TranslatesController');
    $router->resource('walletinfo', 'WalletInfoController'); #钱包地址
    $router->resource('Contact', 'ContactInfoController'); #联系我们地址
    $router->resource('navigate', 'NavigationController'); #导航|底部配置
    $router->resource('enquiries', 'AdvicesCategoryController'); #导航|底部配置
    $router->resource('app-version', 'AppVersionController'); #APP版本管理

    $router->resource('btc-accounts', 'BTCAccountsController');
    $router->resource('eth-accounts', 'ETHAccountsController');
    $router->resource('trx-accounts', 'TRXAccountsController');
    $router->resource('erc20usdt-accounts', 'ETHUSDTAccountsController');
    $router->resource('omniusdt-accounts', 'OMNIUSDTAccountsController');
    $router->resource('trxusdt-accounts', 'TRXUSDTAccountsController');
    $router->resource('center-wallet', 'CenterWalletController');
    $router->resource('wallet-collection', 'WalletCollectionController');

    $router->resource('contract-account', 'ContractAccountController'); // 永续合约账户
    $router->resource('contract-pair', 'ContractPairController'); // 永续合约
    $router->resource('contract-entrust', 'ContractEntrustController'); // 永续合约委托
    $router->resource('contract-order', 'ContractOrderController'); // 永续合约成交记录
    $router->resource('contract-position', 'ContractPositionController'); // 合约持仓记录
    $router->resource('contract-wear-position-record', 'ContractWearPositionRecordController'); // 合约穿仓记录

    // $router->resource('contract-anomaly','ContractAnomalyController'); // 永续合约-异常检测
    $router->resource('contract-settlement', 'ContractSettlementController'); // 合约结算
    $router->resource('subscribe-settlement', 'SubscribeSettlementController'); // 申购结算
    $router->resource('option-settlement', 'OptionSettlementController'); // 期权结算
    $router->resource('performance', 'PerformanceController'); // 代理业绩

    $router->resource('inside-trade-risk', 'InsideTradeRiskController');
    $router->resource('inside-trade-deal-robot', 'InsideTradeDealRobotController');
    $router->resource('contract-deal-robot', 'ContractDealRobotController');
    $router->resource('contract-risk', 'ContractRiskController');
    $router->resource('contract-share', 'ContractShareController');

    // 法币交易
    $router->resource('otc-coinlist', 'OtcCoinlistController');
    $router->resource('otc-account', 'OtcAccountController');
    $router->resource('otc-entrust', 'OtcEntrustController');
    $router->resource('otc-order', 'OtcOrderController');
    
    
    //新建法币交易
    $router->resource('user-legal', 'UserLegalController');

    // 控盘行情
    $router->resource('kline-robot', 'KlineRobotController');
    $router->get('generateKline', 'KlineRobotController@generateKline');
    $router->get('kline', 'KlineRobotController@kline');
    $router->get('kline-data', 'KlineRobotController@kline_data');
    $router->post('kline-save', 'KlineRobotController@kline_save');
    $router->get('getKlineConfig', 'KlineRobotController@getKlineConfig');
    $router->get('getKlineSubscribe', 'KlineRobotController@getKlineSubscribe');

    $router->resource('place', 'PlaceController');

    $router->resource('invite-poster', 'InvitePosterController');
    $router->resource('user-tree', 'UserTreeController');


    $router->resource('error-log', 'ErrorLogController'); #校验日记
    
    //矿机
    $router->resource('kuangji-list', 'KuangjListiController'); //矿机列表
    $router->resource('kuangji-cycle', 'KuangjCycleController'); //矿机列表
    $router->resource('kuangji-account', 'KuangjAccountController'); //矿机钱包
    $router->resource('kuangji-coinlist', 'KuangjCoinlistController'); //矿机币种
    $router->resource('kuangji-kuangj', 'KuangjCoinlistController'); //矿机币种
    $router->resource('kuangji-order', 'KuangjOrderController'); //矿机币种
    //秒合约
    $router->resource('second-config', 'SecondConfigController');
    $router->resource('second-order', 'SecondOrderController');
    $router->resource('second-user', 'SecondUserController');

});
