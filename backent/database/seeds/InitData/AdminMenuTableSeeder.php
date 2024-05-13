<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('admin_menu')->delete();

        DB::table('admin_menu')->insert(array(
            0 =>
            array(
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Index',
                'icon' => 'feather icon-bar-chart-2',
                'uri' => '/',
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'parent_id' => 0,
                'order' => 2,
                'title' => 'Admin',
                'icon' => 'feather icon-settings',
                'uri' => NULL,
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => '2020-09-15 14:03:52',
            ),
            2 =>
            array(
                'id' => 3,
                'parent_id' => 2,
                'order' => 3,
                'title' => 'Users',
                'icon' => '',
                'uri' => 'auth/users',
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'parent_id' => 2,
                'order' => 4,
                'title' => 'Roles',
                'icon' => '',
                'uri' => 'auth/roles',
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => NULL,
            ),
            4 =>
            array(
                'id' => 5,
                'parent_id' => 2,
                'order' => 5,
                'title' => 'Permission',
                'icon' => '',
                'uri' => 'auth/permissions',
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => NULL,
            ),
            5 =>
            array(
                'id' => 6,
                'parent_id' => 2,
                'order' => 6,
                'title' => 'Menu',
                'icon' => '',
                'uri' => 'auth/menu',
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => NULL,
            ),
            6 =>
            array(
                'id' => 7,
                'parent_id' => 2,
                'order' => 7,
                'title' => 'Operation log',
                'icon' => '',
                'uri' => 'auth/logs',
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => NULL,
            ),
            7 =>
            array(
                'id' => 8,
                'parent_id' => 0,
                'order' => 8,
                'title' => '用户管理',
                'icon' => 'fa-user-md',
                'uri' => NULL,
                'created_at' => '2020-06-18 16:02:32',
                'updated_at' => '2020-08-14 17:00:11',
            ),
            8 =>
            array(
                'id' => 9,
                'parent_id' => 8,
                'order' => 9,
                'title' => '用户列表',
                'icon' => NULL,
                'uri' => 'users',
                'created_at' => '2020-06-20 16:24:46',
                'updated_at' => '2020-06-20 16:24:46',
            ),
            9 =>
            array(
                'id' => 10,
                'parent_id' => 8,
                'order' => 10,
                'title' => '实名认证',
                'icon' => NULL,
                'uri' => 'user-auth',
                'created_at' => '2020-06-20 16:42:25',
                'updated_at' => '2020-06-20 16:42:25',
            ),
            10 =>
            array(
                'id' => 11,
                'parent_id' => 0,
                'order' => 32,
                'title' => '期权交易',
                'icon' => 'fa-bitcoin',
                'uri' => NULL,
                'created_at' => '2020-06-23 11:11:47',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            11 =>
            array(
                'id' => 12,
                'parent_id' => 0,
                'order' => 44,
                'title' => '文章管理',
                'icon' => 'fa-newspaper-o',
                'uri' => NULL,
                'created_at' => '2020-06-23 11:12:39',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            12 =>
            array(
                'id' => 13,
                'parent_id' => 12,
                'order' => 45,
                'title' => '文章列表',
                'icon' => NULL,
                'uri' => 'article',
                'created_at' => '2020-06-23 11:16:23',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            13 =>
            array(
                'id' => 14,
                'parent_id' => 12,
                'order' => 46,
                'title' => '文章分类',
                'icon' => NULL,
                'uri' => 'article-category',
                'created_at' => '2020-06-23 11:16:38',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            14 =>
            array(
                'id' => 16,
                'parent_id' => 11,
                'order' => 33,
                'title' => '交易对',
                'icon' => NULL,
                'uri' => 'option-pair',
                'created_at' => '2020-06-23 11:55:00',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            15 =>
            array(
                'id' => 17,
                'parent_id' => 11,
                'order' => 34,
                'title' => '周期',
                'icon' => NULL,
                'uri' => 'option-time',
                'created_at' => '2020-06-23 11:55:12',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            16 =>
            array(
                'id' => 18,
                'parent_id' => 0,
                'order' => 19,
                'title' => '财务管理',
                'icon' => 'fa-usd',
                'uri' => NULL,
                'created_at' => '2020-07-14 18:01:55',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            17 =>
            array(
                'id' => 19,
                'parent_id' => 18,
                'order' => 20,
                'title' => '充币记录',
                'icon' => NULL,
                'uri' => 'recharge',
                'created_at' => '2020-07-14 18:08:27',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            18 =>
            array(
                'id' => 20,
                'parent_id' => 18,
                'order' => 21,
                'title' => '提币审核',
                'icon' => NULL,
                'uri' => 'withdraw',
                'created_at' => '2020-07-14 18:08:42',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            19 =>
            array(
                'id' => 21,
                'parent_id' => 11,
                'order' => 35,
                'title' => '期权订单',
                'icon' => NULL,
                'uri' => 'option-order',
                'created_at' => '2020-07-17 19:07:25',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            20 =>
            array(
                'id' => 22,
                'parent_id' => 0,
                'order' => 51,
                'title' => '首页管理',
                'icon' => 'fa-align-justify',
                'uri' => NULL,
                'created_at' => '2020-07-19 16:33:40',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            21 =>
            array(
                'id' => 23,
                'parent_id' => 22,
                'order' => 52,
                'title' => '联系我们',
                'icon' => NULL,
                'uri' => 'advice',
                'created_at' => '2020-07-19 16:34:54',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            22 =>
            array(
                'id' => 24,
                'parent_id' => 22,
                'order' => 53,
                'title' => '轮播图管理',
                'icon' => NULL,
                'uri' => 'banner',
                'created_at' => '2020-07-19 16:37:16',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            23 =>
            array(
                'id' => 28,
                'parent_id' => 0,
                'order' => 27,
                'title' => '币币交易',
                'icon' => 'fa-bold',
                'uri' => NULL,
                'created_at' => '2020-07-20 04:18:31',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            24 =>
            array(
                'id' => 29,
                'parent_id' => 28,
                'order' => 28,
                'title' => '买入委托',
                'icon' => NULL,
                'uri' => 'inside-trade-buy',
                'created_at' => '2020-07-20 04:19:24',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            25 =>
            array(
                'id' => 30,
                'parent_id' => 0,
                'order' => 37,
                'title' => '永续合约',
                'icon' => 'fa-chain',
                'uri' => NULL,
                'created_at' => '2020-07-20 04:19:44',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            26 =>
            array(
                'id' => 31,
                'parent_id' => 30,
                'order' => 38,
                'title' => '合约列表',
                'icon' => NULL,
                'uri' => 'contract-pair',
                'created_at' => '2020-07-20 04:20:38',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            27 =>
            array(
                'id' => 35,
                'parent_id' => 0,
                'order' => 55,
                'title' => '配置管理',
                'icon' => 'fa-wrench',
                'uri' => NULL,
                'created_at' => '2020-07-20 04:32:34',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            28 =>
            array(
                'id' => 38,
                'parent_id' => 35,
                'order' => 56,
                'title' => '通用配置',
                'icon' => NULL,
                'uri' => 'admin-setting',
                'created_at' => '2020-07-20 04:35:22',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            29 =>
            array(
                'id' => 39,
                'parent_id' => 18,
                'order' => 24,
                'title' => '用户资产',
                'icon' => NULL,
                'uri' => 'user-assets',
                'created_at' => '2020-07-20 04:37:48',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            30 =>
            array(
                'id' => 40,
                'parent_id' => 18,
                'order' => 23,
                'title' => '资产明细',
                'icon' => NULL,
                'uri' => 'user-wallet-log',
                'created_at' => '2020-07-20 04:38:57',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            31 =>
            array(
                'id' => 41,
                'parent_id' => 18,
                'order' => 25,
                'title' => '币种列表',
                'icon' => NULL,
                'uri' => 'coin',
                'created_at' => '2020-07-20 15:01:45',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            32 =>
            array(
                'id' => 42,
                'parent_id' => 28,
                'order' => 31,
                'title' => '交易对',
                'icon' => NULL,
                'uri' => 'inside-trade-pair',
                'created_at' => '2020-07-20 15:21:27',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            33 =>
            array(
                'id' => 49,
                'parent_id' => 35,
                'order' => 57,
                'title' => '联系我们信息',
                'icon' => NULL,
                'uri' => 'Contact',
                'created_at' => '2020-07-31 22:41:56',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            34 =>
            array(
                'id' => 53,
                'parent_id' => 35,
                'order' => 58,
                'title' => '导航栏配置',
                'icon' => NULL,
                'uri' => 'navigate',
                'created_at' => '2020-08-04 19:24:17',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            35 =>
            array(
                'id' => 56,
                'parent_id' => 11,
                'order' => 36,
                'title' => '期权场景',
                'icon' => NULL,
                'uri' => 'option-scene',
                'created_at' => '2020-08-07 19:50:58',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            36 =>
            array(
                'id' => 57,
                'parent_id' => 22,
                'order' => 54,
                'title' => '咨询项目',
                'icon' => NULL,
                'uri' => 'enquiries',
                'created_at' => '2020-08-08 14:45:12',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            37 =>
            array(
                'id' => 58,
                'parent_id' => 28,
                'order' => 29,
                'title' => '卖出委托',
                'icon' => NULL,
                'uri' => 'inside-trade-sell',
                'created_at' => '2020-08-08 15:43:39',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            38 =>
            array(
                'id' => 60,
                'parent_id' => 18,
                'order' => 22,
                'title' => '划转记录',
                'icon' => NULL,
                'uri' => 'asset-details',
                'created_at' => '2020-08-11 16:55:53',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            39 =>
            array(
                'id' => 61,
                'parent_id' => 28,
                'order' => 30,
                'title' => '成交记录',
                'icon' => NULL,
                'uri' => 'inside-trade-order',
                'created_at' => '2020-08-13 17:18:32',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            40 =>
            array(
                'id' => 62,
                'parent_id' => 35,
                'order' => 59,
                'title' => 'APP版本',
                'icon' => NULL,
                'uri' => 'app-version',
                'created_at' => '2020-08-29 14:40:58',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            41 =>
            array(
                'id' => 63,
                'parent_id' => 0,
                'order' => 47,
                'title' => '申购管理',
                'icon' => 'fa-life-buoy',
                'uri' => NULL,
                'created_at' => '2020-09-07 14:45:10',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            42 =>
            array(
                'id' => 64,
                'parent_id' => 63,
                'order' => 48,
                'title' => '申购中',
                'icon' => NULL,
                'uri' => 'subscription-Management',
                'created_at' => '2020-09-07 14:46:09',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            43 =>
            array(
                'id' => 65,
                'parent_id' => 63,
                'order' => 49,
                'title' => '申购记录',
                'icon' => NULL,
                'uri' => 'subscribe-record',
                'created_at' => '2020-09-07 18:34:48',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            44 =>
            array(
                'id' => 73,
                'parent_id' => 30,
                'order' => 40,
                'title' => '成交明细',
                'icon' => NULL,
                'uri' => 'contract-order',
                'created_at' => '2020-10-17 15:03:41',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            45 =>
            array(
                'id' => 75,
                'parent_id' => 30,
                'order' => 41,
                'title' => '合约持仓',
                'icon' => NULL,
                'uri' => 'contract-position',
                'created_at' => '2020-11-02 14:15:23',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            46 =>
            array(
                'id' => 76,
                'parent_id' => 30,
                'order' => 42,
                'title' => '穿仓记录',
                'icon' => NULL,
                'uri' => 'contract-wear-position-record',
                'created_at' => '2020-11-02 14:15:50',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            47 =>
            array(
                'id' => 77,
                'parent_id' => 30,
                'order' => 43,
                'title' => '合约账户',
                'icon' => NULL,
                'uri' => 'contract-account',
                'created_at' => '2020-11-07 17:44:12',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            48 =>
            array(
                'id' => 85,
                'parent_id' => 35,
                'order' => 60,
                'title' => '合约分享',
                'icon' => NULL,
                'uri' => 'contract-share',
                'created_at' => '2020-11-13 17:47:47',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            49 =>
            array(
                'id' => 95,
                'parent_id' => 0,
                'order' => 11,
                'title' => '代理管理',
                'icon' => 'fa-address-card',
                'uri' => 'Agent',
                'created_at' => '2021-05-13 22:06:45',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            50 =>
            array(
                'id' => 96,
                'parent_id' => 18,
                'order' => 26,
                'title' => '充值审核',
                'icon' => 'fa-adjust',
                'uri' => '/rechargeManual',
                'created_at' => '2021-06-04 17:06:29',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            51 =>
            array(
                'id' => 98,
                'parent_id' => 30,
                'order' => 39,
                'title' => '合约委托',
                'icon' => NULL,
                'uri' => 'contract-entrust',
                'created_at' => '2021-06-29 00:47:48',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            52 =>
            array(
                'id' => 99,
                'parent_id' => 63,
                'order' => 50,
                'title' => '申购活动',
                'icon' => NULL,
                'uri' => 'subscribe-activity',
                'created_at' => '2021-07-01 11:46:23',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            53 =>
            array(
                'id' => 100,
                'parent_id' => 95,
                'order' => 12,
                'title' => '代理列表',
                'icon' => NULL,
                'uri' => 'Agent',
                'created_at' => '2021-07-02 19:02:13',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            54 =>
            array(
                'id' => 101,
                'parent_id' => 95,
                'order' => 13,
                'title' => '合约结算',
                'icon' => NULL,
                'uri' => 'contract-settlement',
                'created_at' => '2021-07-02 19:03:34',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            55 =>
            array(
                'id' => 102,
                'parent_id' => 95,
                'order' => 14,
                'title' => '申购结算',
                'icon' => NULL,
                'uri' => 'subscribe-settlement',
                'created_at' => '2021-07-03 16:42:06',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            56 =>
            array(
                'id' => 103,
                'parent_id' => 95,
                'order' => 15,
                'title' => '期权结算',
                'icon' => NULL,
                'uri' => 'option-settlement',
                'created_at' => '2021-07-04 16:48:51',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            57 =>
            array(
                'id' => 104,
                'parent_id' => 95,
                'order' => 16,
                'title' => '代理业绩',
                'icon' => NULL,
                'uri' => 'performance',
                'created_at' => '2021-07-12 15:17:47',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            58 =>
            array(
                'id' => 105,
                'parent_id' => 95,
                'order' => 17,
                'title' => '代理返佣记录(合约)',
                'icon' => NULL,
                'uri' => 'agent/contract-rebate',
                'created_at' => '2021-08-04 09:39:07',
                'updated_at' => '2021-08-04 22:25:26',
            ),
            59 =>
            array(
                'id' => 106,
                'parent_id' => 0,
                'order' => 18,
                'title' => '渠道商',
                'icon' => 'fa-user-circle',
                'uri' => 'place',
                'created_at' => '2021-08-04 22:25:08',
                'updated_at' => '2021-08-04 22:25:48',
            ),
        ));
    }
}
