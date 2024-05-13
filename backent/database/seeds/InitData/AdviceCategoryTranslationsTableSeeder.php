<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdviceCategoryTranslationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('advice_category_translations')->delete();

        DB::table('advice_category_translations')->insert(array(
            0 =>
            array(
                'id' => 1,
                'locale' => 'zh-CN',
                'category_id' => 1,
                'name' => '注册&登录',
            ),
            1 =>
            array(
                'id' => 2,
                'locale' => 'en',
                'category_id' => 1,
                'name' => 'Register & Login',
            ),
            2 =>
            array(
                'id' => 3,
                'locale' => 'zh-TW',
                'category_id' => 1,
                'name' => '註冊&登錄',
            ),
            3 =>
            array(
                'id' => 4,
                'locale' => 'zh-CN',
                'category_id' => 2,
                'name' => '现货交易相关咨询',
            ),
            4 =>
            array(
                'id' => 5,
                'locale' => 'en',
                'category_id' => 2,
                'name' => 'Exchange/Spot Trading',
            ),
            5 =>
            array(
                'id' => 6,
                'locale' => 'zh-TW',
                'category_id' => 2,
                'name' => '現貨交易相關咨詢',
            ),
            6 =>
            array(
                'id' => 7,
                'locale' => 'zh-CN',
                'category_id' => 3,
                'name' => '合约交易相关咨询',
            ),
            7 =>
            array(
                'id' => 8,
                'locale' => 'en',
                'category_id' => 3,
                'name' => 'Contract Trading',
            ),
            8 =>
            array(
                'id' => 9,
                'locale' => 'en',
                'category_id' => 4,
                'name' => 'Account & Security',
            ),
            9 =>
            array(
                'id' => 10,
                'locale' => 'zh-CN',
                'category_id' => 4,
                'name' => '账户 & 安全',
            ),
            10 =>
            array(
                'id' => 11,
                'locale' => 'zh-TW',
                'category_id' => 4,
                'name' => '賬戶 & 安全',
            ),
            11 =>
            array(
                'id' => 12,
                'locale' => 'zh-CN',
                'category_id' => 5,
                'name' => '充值 & 提币',
            ),
            12 =>
            array(
                'id' => 13,
                'locale' => 'en',
                'category_id' => 5,
                'name' => 'Deposit & Withdrawal',
            ),
            13 =>
            array(
                'id' => 14,
                'locale' => 'zh-CN',
                'category_id' => 6,
                'name' => '个人账户认证咨询',
            ),
            14 =>
            array(
                'id' => 15,
                'locale' => 'zh-TW',
                'category_id' => 6,
                'name' => '個人賬戶認證咨詢',
            ),
            15 =>
            array(
                'id' => 16,
                'locale' => 'en',
                'category_id' => 6,
                'name' => 'Individual Account Verification',
            ),
            16 =>
            array(
                'id' => 17,
                'locale' => 'zh-CN',
                'category_id' => 7,
                'name' => '企业账户认证咨询',
            ),
            17 =>
            array(
                'id' => 18,
                'locale' => 'en',
                'category_id' => 7,
                'name' => 'Corporate Account Verification',
            ),
            18 =>
            array(
                'id' => 19,
                'locale' => 'zh-TW',
                'category_id' => 7,
                'name' => '企業賬戶認證咨詢',
            ),
            19 =>
            array(
                'id' => 20,
                'locale' => 'en',
                'category_id' => 8,
                'name' => 'Others',
            ),
            20 =>
            array(
                'id' => 21,
                'locale' => 'zh-CN',
                'category_id' => 8,
                'name' => '其他',
            ),
            21 =>
            array(
                'id' => 22,
                'locale' => 'zh-TW',
                'category_id' => 8,
                'name' => '其他',
            ),
            22 =>
            array(
                'id' => 23,
                'locale' => 'zh-TW',
                'category_id' => 3,
                'name' => '合約交易相關咨詢',
            ),
            23 =>
            array(
                'id' => 24,
                'locale' => 'zh-TW',
                'category_id' => 5,
                'name' => '充值 & 提幣',
            ),
        ));
    }
}
