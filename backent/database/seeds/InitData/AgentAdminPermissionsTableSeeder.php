<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentAdminPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('agent_admin_permissions')->delete();

        DB::table('agent_admin_permissions')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Auth management',
                'slug' => 'auth-management',
                'http_method' => '',
                'http_path' => '',
                'order' => 1,
                'parent_id' => 0,
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'Users',
                'slug' => 'users',
                'http_method' => '',
                'http_path' => '/auth/users*',
                'order' => 2,
                'parent_id' => 1,
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'Roles',
                'slug' => 'roles',
                'http_method' => '',
                'http_path' => '/auth/roles*',
                'order' => 3,
                'parent_id' => 1,
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'name' => 'Permissions',
                'slug' => 'permissions',
                'http_method' => '',
                'http_path' => '/auth/permissions*',
                'order' => 4,
                'parent_id' => 1,
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => NULL,
            ),
            4 =>
            array(
                'id' => 5,
                'name' => 'Menu',
                'slug' => 'menu',
                'http_method' => '',
                'http_path' => '/auth/menu*',
                'order' => 5,
                'parent_id' => 1,
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => NULL,
            ),
            5 =>
            array(
                'id' => 6,
                'name' => 'Operation log',
                'slug' => 'operation-log',
                'http_method' => '',
                'http_path' => '/auth/logs*',
                'order' => 6,
                'parent_id' => 1,
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => '2020-07-24 18:13:59',
            ),
            6 =>
            array(
                'id' => 24,
                'name' => '用户中心',
                'slug' => 'user',
                'http_method' => '',
                'http_path' => '',
                'order' => 14,
                'parent_id' => 0,
                'created_at' => '2020-08-06 17:48:54',
                'updated_at' => '2021-08-06 09:49:46',
            ),
            7 =>
            array(
                'id' => 25,
                'name' => '团队列表',
                'slug' => 'team-list',
                'http_method' => '',
                'http_path' => '/user/team-list*',
                'order' => 16,
                'parent_id' => 24,
                'created_at' => '2020-08-06 17:49:32',
                'updated_at' => '2021-08-06 09:49:46',
            ),
            8 =>
            array(
                'id' => 26,
                'name' => '财务管理',
                'slug' => 'tj',
                'http_method' => '',
                'http_path' => '',
                'order' => 18,
                'parent_id' => 0,
                'created_at' => '2020-08-06 17:50:40',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            9 =>
            array(
                'id' => 27,
                'name' => '提币记录',
                'slug' => 'tb',
                'http_method' => '',
                'http_path' => '/finance/withdraw*',
                'order' => 20,
                'parent_id' => 26,
                'created_at' => '2020-08-06 17:51:13',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            10 =>
            array(
                'id' => 28,
                'name' => '充币记录',
                'slug' => 'cb',
                'http_method' => '',
                'http_path' => '/finance/recharge*',
                'order' => 19,
                'parent_id' => 26,
                'created_at' => '2020-08-06 17:56:00',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            11 =>
            array(
                'id' => 29,
                'name' => '划转记录',
                'slug' => 'hzjl',
                'http_method' => '',
                'http_path' => '/finance/transfer*',
                'order' => 21,
                'parent_id' => 26,
                'created_at' => '2020-08-06 17:56:42',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            12 =>
            array(
                'id' => 37,
                'name' => '直推列表',
                'slug' => 'user-list',
                'http_method' => '',
                'http_path' => '/user/user-list*',
                'order' => 15,
                'parent_id' => 24,
                'created_at' => '2020-08-06 18:02:15',
                'updated_at' => '2021-08-06 09:49:46',
            ),
            13 =>
            array(
                'id' => 38,
                'name' => '代理中心',
                'slug' => 'ddzx',
                'http_method' => '',
                'http_path' => '',
                'order' => 7,
                'parent_id' => 0,
                'created_at' => '2020-08-06 18:03:07',
                'updated_at' => '2020-11-14 17:14:43',
            ),
            14 =>
            array(
                'id' => 39,
                'name' => '个人信息',
                'slug' => 'grxx',
                'http_method' => '',
                'http_path' => '/users*',
                'order' => 8,
                'parent_id' => 38,
                'created_at' => '2020-08-06 18:03:46',
                'updated_at' => '2020-11-14 17:14:44',
            ),
            15 =>
            array(
                'id' => 44,
                'name' => '用户资产',
                'slug' => 'assets',
                'http_method' => '',
                'http_path' => '/finance/user-assets*',
                'order' => 22,
                'parent_id' => 26,
                'created_at' => '2020-11-14 17:16:21',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            16 =>
            array(
                'id' => 45,
                'name' => '资产明细',
                'slug' => 'asset-logs',
                'http_method' => '',
                'http_path' => '/finance/user-wallet-log*',
                'order' => 23,
                'parent_id' => 26,
                'created_at' => '2020-11-14 17:16:58',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            17 =>
            array(
                'id' => 56,
                'name' => '合约结算',
                'slug' => 'contract-settlement',
                'http_method' => '',
                'http_path' => '/contract-settlement*',
                'order' => 9,
                'parent_id' => 38,
                'created_at' => '2021-07-12 15:50:40',
                'updated_at' => '2021-08-05 15:20:27',
            ),
            18 =>
            array(
                'id' => 57,
                'name' => '申购结算',
                'slug' => 'subscribe-settlement',
                'http_method' => '',
                'http_path' => '/subscribe-settlement*',
                'order' => 10,
                'parent_id' => 38,
                'created_at' => '2021-07-12 15:51:02',
                'updated_at' => '2021-08-05 15:20:27',
            ),
            19 =>
            array(
                'id' => 58,
                'name' => '期权结算',
                'slug' => 'option-settlement',
                'http_method' => '',
                'http_path' => '/option-settlement*',
                'order' => 11,
                'parent_id' => 38,
                'created_at' => '2021-07-12 15:51:20',
                'updated_at' => '2021-08-05 15:20:27',
            ),
            20 =>
            array(
                'id' => 59,
                'name' => '代理业绩',
                'slug' => 'performance',
                'http_method' => '',
                'http_path' => '/performance*',
                'order' => 12,
                'parent_id' => 38,
                'created_at' => '2021-07-12 15:51:37',
                'updated_at' => '2021-08-05 15:20:27',
            ),
            21 =>
            array(
                'id' => 61,
                'name' => '期权交易',
                'slug' => 'option',
                'http_method' => '',
                'http_path' => '',
                'order' => 24,
                'parent_id' => 0,
                'created_at' => '2021-08-05 15:53:29',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            22 =>
            array(
                'id' => 62,
                'name' => '期权订单',
                'slug' => 'option-order',
                'http_method' => '',
                'http_path' => '/option/option-order*',
                'order' => 25,
                'parent_id' => 61,
                'created_at' => '2021-08-05 15:54:15',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            23 =>
            array(
                'id' => 63,
                'name' => '合约交易',
                'slug' => 'contract',
                'http_method' => '',
                'http_path' => '',
                'order' => 26,
                'parent_id' => 0,
                'created_at' => '2021-08-05 15:55:05',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            24 =>
            array(
                'id' => 64,
                'name' => '合约委托',
                'slug' => 'contract-entrust',
                'http_method' => '',
                'http_path' => '/contract/contract-entrust*',
                'order' => 27,
                'parent_id' => 63,
                'created_at' => '2021-08-05 15:56:01',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            25 =>
            array(
                'id' => 65,
                'name' => '合约持仓',
                'slug' => 'contract-position',
                'http_method' => '',
                'http_path' => '/contract/contract-position*',
                'order' => 28,
                'parent_id' => 63,
                'created_at' => '2021-08-05 15:56:57',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            26 =>
            array(
                'id' => 66,
                'name' => '穿仓记录',
                'slug' => 'contract-wear-position-record',
                'http_method' => '',
                'http_path' => '/contract/contract-wear-position-record*',
                'order' => 29,
                'parent_id' => 63,
                'created_at' => '2021-08-05 15:58:06',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            27 =>
            array(
                'id' => 67,
                'name' => '合约账户',
                'slug' => 'contract-account',
                'http_method' => '',
                'http_path' => '/contract/contract-account*',
                'order' => 30,
                'parent_id' => 63,
                'created_at' => '2021-08-05 16:00:20',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            28 =>
            array(
                'id' => 68,
                'name' => '申购记录',
                'slug' => 'contract-purchase',
                'http_method' => '',
                'http_path' => '/contract/contract-purchase*',
                'order' => 31,
                'parent_id' => 63,
                'created_at' => '2021-08-05 16:01:22',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            29 =>
            array(
                'id' => 69,
                'name' => '币币交易',
                'slug' => 'exchange',
                'http_method' => '',
                'http_path' => '',
                'order' => 32,
                'parent_id' => 0,
                'created_at' => '2021-08-05 18:19:19',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            30 =>
            array(
                'id' => 70,
                'name' => '买入委托',
                'slug' => 'trade-buy',
                'http_method' => '',
                'http_path' => '/exchange/trade-buy*',
                'order' => 33,
                'parent_id' => 69,
                'created_at' => '2021-08-05 18:20:12',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            31 =>
            array(
                'id' => 71,
                'name' => '卖出委托',
                'slug' => 'trade-sell',
                'http_method' => '',
                'http_path' => '/exchange/trade-sell*',
                'order' => 34,
                'parent_id' => 69,
                'created_at' => '2021-08-05 18:20:48',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            32 =>
            array(
                'id' => 72,
                'name' => '成交记录',
                'slug' => 'trade-order',
                'http_method' => '',
                'http_path' => '/exchange/trade-order*',
                'order' => 35,
                'parent_id' => 69,
                'created_at' => '2021-08-05 18:21:28',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            33 =>
            array(
                'id' => 73,
                'name' => '代理列表',
                'slug' => 'agent-list',
                'http_method' => '',
                'http_path' => '/agent/list*',
                'order' => 13,
                'parent_id' => 38,
                'created_at' => '2021-08-05 19:16:33',
                'updated_at' => '2021-08-06 09:48:10',
            ),
            34 =>
            array(
                'id' => 74,
                'name' => '成交记录',
                'slug' => 'contract-order',
                'http_method' => '',
                'http_path' => '/contract/contract-order*',
                'order' => 36,
                'parent_id' => 63,
                'created_at' => '2021-08-06 14:42:45',
                'updated_at' => '2021-08-06 14:42:45',
            ),
            35 =>
            array(
                'id' => 75,
                'name' => '返佣记录(合约)',
                'slug' => 'contract-rebate',
                'http_method' => '',
                'http_path' => '/agent/contract-rebate*',
                'order' => 37,
                'parent_id' => 0,
                'created_at' => '2021-08-07 01:55:07',
                'updated_at' => '2021-08-07 01:55:07',
            ),
            36 =>
            array(
                'id' => 76,
                'name' => '盈亏(渠道商专属)',
                'slug' => 'profitandloss',
                'http_method' => '',
                'http_path' => '',
                'order' => 15,
                'parent_id' => 0,
                'created_at' => '2021-08-16 14:22:51',
                'updated_at' => '2021-08-16 14:23:21',
            ),
            37 =>
            array(
                'id' => 77,
                'name' => '合约盈亏明细',
                'slug' => 'contract-order-profit',
                'http_method' => '',
                'http_path' => '/profitandloss/contract-entrust-profit*',
                'order' => 38,
                'parent_id' => 76,
                'created_at' => '2021-08-16 14:32:20',
                'updated_at' => '2021-08-16 14:50:47',
            ),
        ));
    }
}
