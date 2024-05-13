<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NavigationTranslationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('navigation_translations')->delete();

        DB::table('navigation_translations')->insert(array(
            0 =>
            array(
                'id' => 1,
                'locale' => 'zh-CN',
                'name' => '币币交易',
                'n_id' => 11,
            ),
            1 =>
            array(
                'id' => 2,
                'locale' => 'zh-CN',
                'name' => '币币交易',
                'n_id' => 11,
            ),
            2 =>
            array(
                'id' => 3,
                'locale' => 'en',
                'name' => 'Currency transaction',
                'n_id' => 11,
            ),
            3 =>
            array(
                'id' => 4,
                'locale' => 'zh-TW',
                'name' => '幣幣交易',
                'n_id' => 11,
            ),
            4 =>
            array(
                'id' => 5,
                'locale' => 'zh-CN',
                'name' => '行情',
                'n_id' => 12,
            ),
            5 =>
            array(
                'id' => 6,
                'locale' => 'en',
                'name' => 'Quotation',
                'n_id' => 12,
            ),
            6 =>
            array(
                'id' => 7,
                'locale' => 'zh-TW',
                'name' => '行情',
                'n_id' => 12,
            ),
            7 =>
            array(
                'id' => 8,
                'locale' => 'zh-CN',
                'name' => '打新专区',
                'n_id' => 13,
            ),
            8 =>
            array(
                'id' => 9,
                'locale' => 'en',
                'name' => 'New zone',
                'n_id' => 13,
            ),
            9 =>
            array(
                'id' => 10,
                'locale' => 'zh-TW',
                'name' => '打新專區',
                'n_id' => 13,
            ),
            10 =>
            array(
                'id' => 11,
                'locale' => 'zh-CN',
                'name' => '申购',
                'n_id' => 14,
            ),
            11 =>
            array(
                'id' => 12,
                'locale' => 'en',
                'name' => 'Purchase',
                'n_id' => 14,
            ),
            12 =>
            array(
                'id' => 13,
                'locale' => 'zh-TW',
                'name' => '申購',
                'n_id' => 14,
            ),
            13 =>
            array(
                'id' => 14,
                'locale' => 'zh-CN',
                'name' => '学院',
                'n_id' => 15,
            ),
            14 =>
            array(
                'id' => 15,
                'locale' => 'en',
                'name' => 'College',
                'n_id' => 15,
            ),
            15 =>
            array(
                'id' => 16,
                'locale' => 'zh-TW',
                'name' => '學院',
                'n_id' => 15,
            ),
            16 =>
            array(
                'id' => 17,
                'locale' => 'zh-CN',
                'name' => '联系我们',
                'n_id' => 16,
            ),
            17 =>
            array(
                'id' => 18,
                'locale' => 'en',
                'name' => 'Contact Us',
                'n_id' => 16,
            ),
            18 =>
            array(
                'id' => 19,
                'locale' => 'zh-TW',
                'name' => '聯系我們',
                'n_id' => 16,
            ),
            19 =>
            array(
                'id' => 20,
                'locale' => 'zh-CN',
                'name' => '用户协议',
                'n_id' => 17,
            ),
            20 =>
            array(
                'id' => 21,
                'locale' => 'zh-TW',
                'name' => '用戶協議',
                'n_id' => 17,
            ),
            21 =>
            array(
                'id' => 22,
                'locale' => 'en',
                'name' => 'User Agreement',
                'n_id' => 17,
            ),
            22 =>
            array(
                'id' => 23,
                'locale' => 'zh-CN',
                'name' => '隐私条款',
                'n_id' => 18,
            ),
            23 =>
            array(
                'id' => 24,
                'locale' => 'en',
                'name' => 'Privacy policy',
                'n_id' => 18,
            ),
            24 =>
            array(
                'id' => 25,
                'locale' => 'zh-TW',
                'name' => '隱私條款',
                'n_id' => 18,
            ),
            25 =>
            array(
                'id' => 26,
                'locale' => 'zh-CN',
                'name' => '法律声明',
                'n_id' => 19,
            ),
            26 =>
            array(
                'id' => 27,
                'locale' => 'en',
                'name' => 'Legal Notice',
                'n_id' => 19,
            ),
            27 =>
            array(
                'id' => 28,
                'locale' => 'zh-TW',
                'name' => '法律聲明',
                'n_id' => 19,
            ),
            28 =>
            array(
                'id' => 29,
                'locale' => 'zh-CN',
                'name' => '关于我们',
                'n_id' => 20,
            ),
            29 =>
            array(
                'id' => 30,
                'locale' => 'en',
                'name' => 'About Us',
                'n_id' => 20,
            ),
            30 =>
            array(
                'id' => 31,
                'locale' => 'zh-TW',
                'name' => '關於我們',
                'n_id' => 20,
            ),
            31 =>
            array(
                'id' => 32,
                'locale' => 'zh-CN',
                'name' => '新手教程',
                'n_id' => 21,
            ),
            32 =>
            array(
                'id' => 33,
                'locale' => 'en',
                'name' => 'Beginners Guide',
                'n_id' => 21,
            ),
            33 =>
            array(
                'id' => 34,
                'locale' => 'zh-TW',
                'name' => '新手教程',
                'n_id' => 21,
            ),
            34 =>
            array(
                'id' => 35,
                'locale' => 'en',
                'name' => 'Industry Research',
                'n_id' => 22,
            ),
            35 =>
            array(
                'id' => 36,
                'locale' => 'zh-CN',
                'name' => '行业研究',
                'n_id' => 22,
            ),
            36 =>
            array(
                'id' => 37,
                'locale' => 'zh-TW',
                'name' => '行業研究',
                'n_id' => 22,
            ),
            37 =>
            array(
                'id' => 38,
                'locale' => 'zh-CN',
                'name' => '市场动态',
                'n_id' => 23,
            ),
            38 =>
            array(
                'id' => 39,
                'locale' => 'en',
                'name' => 'Market News',
                'n_id' => 23,
            ),
            39 =>
            array(
                'id' => 40,
                'locale' => 'zh-TW',
                'name' => '市場動態',
                'n_id' => 23,
            ),
            40 =>
            array(
                'id' => 41,
                'locale' => 'zh-CN',
                'name' => '房屋资讯',
                'n_id' => 24,
            ),
            41 =>
            array(
                'id' => 42,
                'locale' => 'en',
                'name' => 'Housing information',
                'n_id' => 24,
            ),
            42 =>
            array(
                'id' => 43,
                'locale' => 'zh-TW',
                'name' => '房屋資訊',
                'n_id' => 24,
            ),
        ));
    }
}
