<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSettingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('admin_setting')->delete();

        DB::table('admin_setting')->insert(array(
            0 =>
            array(
                'id' => 1,
                'module' => 'common',
                'title' => '提币二次验证',
                'key' => 'withdraw_switch',
                'value' => '0',
                'type' => 'switch',
                'tips' => NULL,
                'created_at' => '2020-07-24 17:24:49',
                'updated_at' => '2021-07-26 11:18:17',
            ),
            1 =>
            array(
                'id' => 2,
                'module' => 'website',
                'title' => '站点名称',
                'key' => 'name',
                'value' => 'Binvet',
                'type' => 'text',
                'tips' => NULL,
                'created_at' => '2020-08-05 14:04:02',
                'updated_at' => '2021-07-26 11:18:17',
            ),
            2 =>
            array(
                'id' => 3,
                'module' => 'website',
                'title' => '站点标题LOGO',
                'key' => 'titles_logo',
                'value' => 'images/92f8a41d807909929b9ad979572af59a.png',
                'type' => 'image',
                'tips' => NULL,
                'created_at' => '2020-08-05 14:35:18',
                'updated_at' => '2021-07-26 11:18:17',
            ),
            3 =>
            array(
                'id' => 5,
                'module' => 'exchange',
                'title' => 'Maker（挂单）手续费率',
                'key' => 'maker_fee_rate',
                'value' => '0.002',
                'type' => 'text',
                'tips' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            4 =>
            array(
                'id' => 6,
                'module' => 'exchange',
                'title' => 'Taker（吃单）手续费率',
                'key' => 'taker_fee_rate',
                'value' => '0.002',
                'type' => 'text',
                'tips' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            5 =>
            array(
                'id' => 7,
                'module' => 'website',
                'title' => '站点头部LOGO',
                'key' => 'head_logo',
                'value' => 'images/249fc70fe4140172ed7adeaa77784c43.png',
                'type' => 'image',
                'tips' => NULL,
                'created_at' => '2020-08-05 16:19:40',
                'updated_at' => '2021-07-26 11:18:17',
            ),
            6 =>
            array(
                'id' => 8,
                'module' => 'website',
                'title' => '站点底部LOGO',
                'key' => 'foot_logo',
                'value' => 'images/4c5f65c69bfb41a04dc6bb3aab419066.png',
                'type' => 'image',
                'tips' => NULL,
                'created_at' => '2020-08-05 16:19:40',
                'updated_at' => '2021-07-26 11:18:17',
            ),
            7 =>
            array(
                'id' => 12,
                'module' => 'website',
                'title' => '移动端登录LOGO',
                'key' => 'login_logo',
                'value' => 'images/bd10eb0a37cc257c3bf00cfb5ed27568.png',
                'type' => 'image',
                'tips' => NULL,
                'created_at' => '2020-08-05 16:19:40',
                'updated_at' => '2021-07-26 11:18:17',
            ),
            8 =>
            array(
                'id' => 13,
                'module' => 'website',
                'title' => '移动端标题LOGO',
                'key' => 'title_logo',
                'value' => 'images/bb07dc6aff45e37ba29449427142076e.png',
                'type' => 'image',
                'tips' => NULL,
                'created_at' => '2020-08-05 16:19:40',
                'updated_at' => '2021-07-26 11:18:17',
            ),
            9 =>
            array(
                'id' => 14,
                'module' => 'website',
                'title' => '移动端首页LOGO',
                'key' => 'home_logo',
                'value' => 'images/fce20599df8ac26f82e4d934ee764b30.png',
                'type' => 'image',
                'tips' => NULL,
                'created_at' => '2020-08-05 16:19:40',
                'updated_at' => '2021-07-26 11:18:17',
            ),
            10 =>
            array(
                'id' => 20,
                'module' => 'website',
                'title' => '版权信息',
                'key' => 'copyright',
                'value' => '©2020. PCI All Rights Reserved',
                'type' => 'text',
                'tips' => NULL,
                'created_at' => '2020-08-05 16:19:40',
                'updated_at' => '2021-07-26 11:18:17',
            ),
            11 =>
            array(
                'id' => 21,
                'module' => 'exchange',
                'title' => '委托超时关闭时间',
                'key' => 'order_ttl',
                'value' => '120',
                'type' => 'text',
                'tips' => '单位（分钟）',
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            12 =>
            array(
                'id' => 22,
                'module' => 'exchange',
                'title' => '系统自动成交时间',
                'key' => 'deal_time',
                'value' => '10',
                'type' => 'text',
                'tips' => '单位（分钟）',
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            13 =>
            array(
                'id' => 23,
                'module' => 'contract',
                'title' => '强平风险率',
                'key' => 'flat_risk_rate',
                'value' => '0.2',
                'type' => 'text',
                'tips' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            14 =>
            array(
                'id' => 24,
                'module' => 'exchange',
                'title' => '新币行情涨幅最小比率',
                'key' => 'min_rate',
                'value' => '0.08',
                'type' => 'text',
                'tips' => '5%就设置0.05',
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            15 =>
            array(
                'id' => 25,
                'module' => 'exchange',
                'title' => '新币行情涨幅最大比率',
                'key' => 'max_rate',
                'value' => '0.18',
                'type' => 'text',
                'tips' => '18%就设置0.18',
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            16 =>
            array(
                'id' => 26,
                'module' => 'exchange',
                'title' => '新币行情涨跌',
                'key' => 'up_or_down',
                'value' => '1',
                'type' => 'text',
                'tips' => '1涨2跌',
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            17 =>
            array(
                'id' => 30,
                'module' => 'contract',
                'title' => '资金费率',
                'key' => 'cost_rate',
                'value' => '0.0001',
                'type' => 'text',
                'tips' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            18 =>
            array(
                'id' => 31,
                'module' => 'website',
                'title' => '分享LOGO',
                'key' => 'share_logo',
                'value' => 'images/89dba6e40c6cea348239a69062948ae8.png',
                'type' => 'image',
                'tips' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            19 =>
            array(
                'id' => 34,
                'module' => 'otc',
                'title' => '法币订单超时关闭时间（分钟）',
                'key' => 'otc_order_overed',
                'value' => '15',
                'type' => 'text',
                'tips' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-05-05 14:31:18',
            ),
            20 =>
            array(
                'id' => 35,
                'module' => 'otc',
                'title' => '法币订单自动确认时间（小时）',
                'key' => 'otc_order_confirm',
                'value' => '10',
                'type' => 'text',
                'tips' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-05-05 14:31:18',
            ),
            21 =>
            array(
                'id' => 36,
                'module' => 'paypal',
                'title' => 'Paypal账号',
                'key' => 'paypal_account',
                'value' => NULL,
                'type' => 'text',
                'tips' => '前台显示Paypal账号',
                'created_at' => '2021-06-05 11:19:49',
                'updated_at' => '2021-07-26 11:18:17',
            ),
            22 =>
            array(
                'id' => 37,
                'module' => 'paypal',
                'title' => '公告（提示）',
                'key' => 'announce',
                'value' => '请务必上传转账截图',
                'type' => 'text',
                'tips' => '前台公告配置',
                'created_at' => '2021-06-05 11:19:49',
                'updated_at' => '2021-07-26 11:18:17',
            ),
            23 =>
            array(
                'id' => 38,
                'module' => 'coin1',
                'title' => 'BT行情涨幅最小比率',
                'key' => 'min_rate',
                'value' => '0.05',
                'type' => 'text',
                'tips' => '5%就设置0.05',
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            24 =>
            array(
                'id' => 39,
                'module' => 'coin1',
                'title' => 'BT行情涨幅最大比率',
                'key' => 'max_rate',
                'value' => '0.1',
                'type' => 'text',
                'tips' => '18%就设置0.18',
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            25 =>
            array(
                'id' => 40,
                'module' => 'coin1',
                'title' => 'BT行情涨跌',
                'key' => 'up_or_down',
                'value' => '1',
                'type' => 'text',
                'tips' => '1涨2跌',
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            26 =>
            array(
                'id' => 41,
                'module' => 'coin2',
                'title' => 'TKB行情涨幅最小比率',
                'key' => 'min_rate',
                'value' => '0.05',
                'type' => 'text',
                'tips' => '5%就设置0.05',
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            27 =>
            array(
                'id' => 42,
                'module' => 'coin2',
                'title' => 'TKB行情涨幅最大比率',
                'key' => 'max_rate',
                'value' => '0.08',
                'type' => 'text',
                'tips' => '18%就设置0.18',
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
            28 =>
            array(
                'id' => 43,
                'module' => 'coin2',
                'title' => 'TKB行情涨跌',
                'key' => 'up_or_down',
                'value' => '1',
                'type' => 'text',
                'tips' => '1涨2跌',
                'created_at' => NULL,
                'updated_at' => '2021-07-26 11:18:17',
            ),
        ));
    }
}
