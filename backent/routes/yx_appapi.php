<?php

use Dingo\Api\Routing\Router;

$api->group(['namespace' => 'V1'], function ($api) {
    //    $api->any('test','UserController@test');

    $api->any('data/market', 'DataController@market');
    $api->any('data/sceneListNewPrice', 'DataController@sceneListNewPrice');

    //登录注册
    $api->post('register/sendSmsCode', 'LoginController@sendSmsCode'); //注册发送短信验证码
    $api->post('login/sendSmsCodeBeforeLogin', 'LoginController@sendSmsCodeBeforeLogin'); //登陆发送短信验证码
    $api->post('register/sendEmailCode', 'LoginController@sendEmailCode'); //注册发送邮箱验证码
    $api->post('login/sendEmailCodeBeforeLogin', 'LoginController@sendEmailCodeBeforeLogin'); //登陆发送邮箱验证码
    $api->post('user/register', 'LoginController@register'); //注册
    $api->post('user/login', 'LoginController@login'); //登录
    $api->post('user/loginConfirm', 'LoginController@loginConfirm'); //登录二次验证
    //    $api->post('user/verifyLogin','LoginController@verifyLogin');//验证码登录
    $api->post('user/logout', 'LoginController@logout')->name('appapi_user_logout'); //退出登录

    //文章
    $api->get('article/list', 'ArticleController@article_list')->name('appapi_article_list'); //列表
    $api->get('article/detail', 'ArticleController@article_detail'); //详情

    //轮播图
    $api->get('getBanner', 'BannerController@index');

    $api->get('getTranslate', 'CommonController@getTranslate');

    // 获取APP最新版本
    $api->get('getNewestVersion', 'CommonController@getNewestVersion');

    //首页导航
    $api->get('indexNav', 'IndexController@indexNav');

    //上传图片
    $api->post('uploadImage', 'CommonController@uploadImage');
    $api->get('getCountryList', 'CommonController@getCountryList');

    $api->post('sliderVerify', 'LoginController@sliderVerify');

    $api->post('user/sendSmsCodeForgetPassword', 'UserSecurityController@sendSmsCodeForgetPassword'); //忘记密码短信验证码
    $api->post('user/sendEmailCodeForgetPassword', 'UserSecurityController@sendEmailCodeForgetPassword'); //忘记密码邮箱验证码
    $api->post('user/forgetPassword', 'UserSecurityController@forgetPassword'); //忘记登录密码
    $api->post('user/forgetPasswordAttempt', 'UserSecurityController@forgetPasswordAttempt'); //忘记登录密码尝试

    //Data
    $api->get('data/cacheOptionNewPrice', 'DataController@cacheOptionNewPrice');

    $api->get('exchange/getCoinInfo', 'InsideTradeController@getCoinInfo');

    $api->get('exchange/getExchangeSymbol', 'InsideTradeController@getExchangeSymbol'); //获取交易对列表
    $api->get('option/getOptionSymbol', 'OptionSceneController@getOptionSymbol');
    $api->any('option/instruction', 'OptionSceneController@instruction'); //期权玩法说明

    $api->get('exchange/getMarketList', 'InsideTradeController@getMarketList'); //获取币币市场行情
    $api->get('exchange/getMarketInfo', 'InsideTradeController@getMarketInfo'); //获取币币市场行情

    //获取期权相关信息
    $api->get('option/getKline', 'OptionSceneController@getKline'); //获取Kline数据
    $api->get('option/getNewPriceBook', 'OptionSceneController@getNewPriceBook'); //获取初始价格数据
    $api->get('option/getBetCoinList', 'OptionSceneController@getBetCoinList'); //获取可用期权交易币种列表
    $api->get('option/sceneListByPairs', 'OptionSceneController@sceneListByPairs'); //获取全部期权场景
    $api->get('option/sceneListByTimes', 'OptionSceneController@sceneListByTimes'); //获取全部期权场景
    $api->get('option/sceneDetail', 'OptionSceneController@sceneDetail'); //根据交易对和时间周期获取当前最新期权场景
    $api->get('option/getOddsList', 'OptionSceneController@getOddsList'); //根据交易对和时间周期获取当前最新期权场景赔率
    $api->get('option/getSceneResultList', 'OptionSceneController@getSceneResultList'); //获取期权交割记录

    // Exchange市场
    $api->get('market/getCurrencyExCny', 'MarketController@getCurrencyExCny'); //获取CNY汇率

    // 永续合约
    $api->get('contract/tend', 'ContractController@tend'); // 合约多空比趋势
    $api->get('contract/getSymbolDetail', 'ContractController@getSymbolDetail'); // 获取合约信息
    $api->get('contract/getMarketList', 'ContractController@getMarketList'); // 获取合约市场信息
    $api->get('contract/getMarketInfo', 'ContractController@getMarketInfo'); // 获取合约初始化盘面数据
    $api->get('contract/getKline', 'ContractController@getKline'); // 获取合约初始化K线数据
    $api->post('contract/secondContract', 'ContractController@secondContract');  //秒合约
    $api->post('contract/secondContractinit', 'ContractController@secondContractinit');  //秒合约
    $api->get('contract/getHistorysc', 'ContractController@getHistorysc');  //秒合约
    $api->get('contract/getCurrentsc', 'ContractController@getCurrentsc');  //秒合约

    $api->any('contract/instruction', 'ContractController@instruction'); //合约玩法说明
});

$api->group(['namespace' => 'V1', 'middleware' => 'auth.api'], function ($api) {
    //个人中心
    $api->get('user/switchSecondVerify', 'UserController@switchSecondVerify'); //登陆二次验证开关
    $api->get('user/getUserInfo', 'UserController@getUserInfo'); //获取用户信息
    $api->post('user/updateUserInfo', 'UserController@updateUserInfo'); //修改用户信息

    //账号安全
    $api->get('user/switchTradeVerify', 'UserSecurityController@switchTradeVerify'); //交易密码开关
    $api->get('user/security/home', 'UserSecurityController@home'); //账号安全中心
    $api->post('user/getCode', 'UserSecurityController@getCode'); //获取验证码
    $api->post('user/setOrResetPaypwd', 'UserSecurityController@setOrResetPaypwd'); //设置或重置交易密码
    $api->post('user/updatePassword', 'UserSecurityController@updatePassword'); //修改登录密码
    $api->post('user/bindPhone', 'UserSecurityController@bindPhone'); //绑定手机
    $api->post('user/unbindPhone', 'UserSecurityController@unbindPhone'); //解绑手机
    $api->post('user/changePhone', 'UserSecurityController@changePhone'); //换绑手机
    $api->post('user/sendBindSmsCode', 'UserSecurityController@sendBindSmsCode'); //发送绑定手机短信验证码
    $api->post('user/sendBindEmailCode', 'UserSecurityController@sendBindEmailCode'); //发送绑定邮箱短信验证码
    $api->post('user/bindEmail', 'UserSecurityController@bindEmail'); //绑定邮箱
    $api->post('user/unbindEmail', 'UserSecurityController@unbindEmail'); //解绑邮箱
    $api->post('user/changeEmail', 'UserSecurityController@changeEmail'); //换绑邮箱
    $api->post('user/disableSmsEmailGoogle', 'UserSecurityController@disableSmsEmailGoogle'); //关闭手机/邮箱/谷歌验证
    $api->post('user/enableSmsEmailGoogle', 'UserSecurityController@enableSmsEmailGoogle'); //启用手机/邮箱/谷歌验证
    $api->post('user/changePurchaseCode', 'UserSecurityController@changePurchaseCode'); //更改申购码

    //登陆日志
    $api->get('user/getLoginLogs', 'UserController@getLoginLogs');
    $api->get('user/getGradeInfo', 'UserController@getGradeInfo');

    $api->post('user/cancelWithdraw', 'UserWalletController@cancelWithdraw');

    //推广
    $api->group(['prefix' => 'generalize'], function (Router $route) {
        $route->get('info', 'GeneralizeController@getGeneralizeInfo'); //获取推广信息
        $route->get('list', 'GeneralizeController@generalizeList'); //推广邀请记录
        $route->get('rewardLogs', 'GeneralizeController@generalizeRewardLogs'); //推广返佣记录
        $route->post('applyAgency', 'GeneralizeController@applyAgency'); //申请代理
        $route->get('poster', 'GeneralizeController@poster'); //生成推广海报
        $route->get('invite_qrcode', 'GeneralizeController@invite_qrcode'); //生成用户邀请二维码
    });

    //谷歌验证器
    $api->get('user/getGoogleToken', 'GoogleTokenController@getGoogleToken');
    $api->post('user/bindGoogleToken', 'GoogleTokenController@bindGoogleToken');
    $api->post('user/unbindGoogleToken', 'GoogleTokenController@unbindGoogleToken');

    //用户认证
    $api->post('user/primaryAuth', 'UserController@primaryAuth');
    $api->post('user/topAuth', 'UserController@topAuth');
    $api->get('user/getAuthInfo', 'UserController@getAuthInfo');

    //用户消息通知
    $api->get('user/myNotifiablesCount', 'UserController@myNotifiablesCount');
    $api->get('user/myNotifiables', 'UserController@myNotifiables');
    $api->get('user/readNotifiable', 'UserController@readNotifiable');
    $api->get('user/batchReadNotifiables', 'UserController@batchReadNotifiables');

    //用户意见反馈
    $api->get('user/advices', 'UserController@advices');
    $api->get('user/adviceDetail', 'UserController@adviceDetail');
    $api->post('user/addAdvice', 'UserController@addAdvice');

    //用户收款账户
    $api->resource('userPayment', 'UserPaymentController');
    $api->post('userPayment/setStatus/{id}', 'UserPaymentController@setStatus');

    //用户钱包流水
    $api->get('user/getWalletLogs', 'UserWalletController@getWalletLogs');

    //用户法币流水
    $api->get('user/otcWalletLogs', 'UserWalletController@otcWalletLogs');
    
    //购买期权
    $api->get('option/getUserCoinBalance', 'OptionSceneController@getUserCoinBalance'); //获取用户账户资金余额
    $api->get('option/getOptionHistoryOrders', 'OptionSceneController@getOptionHistoryOrders'); //获取用户期权购买记录
    $api->get('option/getOptionOrderDetail', 'OptionSceneController@getOptionOrderDetail'); //获取用户期权购买记录详情
    $api->post('option/betScene', 'OptionSceneController@betScene')->middleware(['checkTradeStatus', 'checkTransactionCode']); //购买期权

    //币币交易
    $api->post('exchange/storeEntrust', 'InsideTradeController@storeEntrust')->middleware(['checkTradeStatus']); //发布委托
    $api->get('exchange/getUserCoinBalance', 'InsideTradeController@getUserCoinBalance'); //根据交易对获取账号余额
    $api->get('exchange/getHistoryEntrust', 'InsideTradeController@getHistoryEntrust'); //获取历史委托
    $api->get('exchange/getCurrentEntrust', 'InsideTradeController@getCurrentEntrust'); //获取当前委托
    $api->get('exchange/getEntrustTradeRecord', 'InsideTradeController@getEntrustTradeRecord'); //获取委托成交记录
    $api->post('exchange/cancelEntrust', 'InsideTradeController@cancelEntrust'); //撤单
    $api->post('exchange/batchCancelEntrust', 'InsideTradeController@batchCancelEntrust'); //批量撤单

    // 永续合约
    $api->group(['middleware' => 'checkContractAccount', 'prefix' => 'contract'], function ($api) {
        $api->get('openStatus', 'ContractController@openStatus'); // 获取永续合约开通状态
        $api->post('opening', 'ContractController@opening'); // 开通永续合约
        $api->get('accountList', 'ContractController@contractAccountList'); // 获取所有合约账户列表
        $api->get('accountFlow', 'ContractController@contractAccountFlow'); // 获取合约账户流水
        $api->get('positionShare', 'ContractController@positionShare'); // 持仓盈亏分享
        $api->get('entrustShare', 'ContractController@entrustShare'); // 委托盈亏分享

        //        $api->group(['middleware'=>'openContract'], function ($api) {
        $api->get('openNum', 'ContractController@openNum'); // 可开张数
        $api->get('contractAccount', 'ContractController@contractAccount'); // 获取用户合约账户信息
        $api->get('holdPosition', 'ContractController@holdPosition'); // 获取用户持仓信息
        $api->post('openPosition', 'ContractController@openPosition')->middleware(['checkTradeStatus', 'checkTransactionCode']); // 合约开仓
        $api->post('closePosition', 'ContractController@closePosition')->middleware(['checkTradeStatus']); // 合约平仓
        $api->post('closeAllPosition', 'ContractController@closeAllPosition')->middleware(['checkTradeStatus']); // 市价全平
        $api->post('onekeyAllFlat', 'ContractController@onekeyAllFlat')->middleware(['checkTradeStatus']); // 一键全平
        $api->post('onekeyReverse', 'ContractController@onekeyReverse')->middleware(['checkTradeStatus']); // 一键反向
        $api->post('setStrategy', 'ContractController@setStrategy')->middleware(['checkTradeStatus']); // 设置止盈止损
        $api->post('cancelEntrust', 'ContractController@cancelEntrust');
        $api->post('batchCancelEntrust', 'ContractController@batchCancelEntrust');
        $api->get('getCurrentEntrust', 'ContractController@getCurrentEntrust');
        $api->get('getHistoryEntrust', 'ContractController@getHistoryEntrust');
        $api->get('getEntrustDealList', 'ContractController@getEntrustDealList');
        $api->get('getDealList', 'ContractController@getDealList');
        //        });
    });

    // 资金划转
    $api->get('wallet/accounts', 'UserWalletController@accounts')->middleware(['checkContractAccount']);
    $api->get('wallet/accountPairList', 'UserWalletController@accountPairList');
    $api->get('wallet/coinList', 'UserWalletController@coinList');
    $api->get('wallet/getBalance', 'UserWalletController@getBalance');
    $api->post('wallet/transfer', 'UserWalletController@transfer')->middleware(['checkContractAccount']);
    $api->get('wallet/transferRecords', 'UserWalletController@transferRecords');
});
