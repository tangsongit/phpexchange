<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTranslationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('category_translations')->delete();

        DB::table('category_translations')->insert(array(
            0 =>
            array(
                'id' => 1,
                'category_id' => 14,
                'locale' => 'en',
                'name' => 'Latest News',
            ),
            1 =>
            array(
                'id' => 2,
                'category_id' => 2,
                'locale' => 'en',
                'name' => 'Help Center',
            ),
            2 =>
            array(
                'id' => 3,
                'category_id' => 2,
                'locale' => 'zh-CN',
                'name' => '帮助中心',
            ),
            3 =>
            array(
                'id' => 4,
                'category_id' => 3,
                'locale' => 'zh-CN',
                'name' => '服务',
            ),
            4 =>
            array(
                'id' => 5,
                'category_id' => 3,
                'locale' => 'en',
                'name' => 'Service',
            ),
            5 =>
            array(
                'id' => 6,
                'category_id' => 3,
                'locale' => 'zh-TW',
                'name' => '服務',
            ),
            6 =>
            array(
                'id' => 7,
                'category_id' => 14,
                'locale' => 'zh-CN',
                'name' => '最新资讯',
            ),
            7 =>
            array(
                'id' => 8,
                'category_id' => 4,
                'locale' => 'zh-CN',
                'name' => '系统公告',
            ),
            8 =>
            array(
                'id' => 9,
                'category_id' => 5,
                'locale' => 'zh-CN',
                'name' => '学院',
            ),
            9 =>
            array(
                'id' => 10,
                'category_id' => 8,
                'locale' => 'zh-CN',
                'name' => '常见问题',
            ),
            10 =>
            array(
                'id' => 11,
                'category_id' => 9,
                'locale' => 'zh-CN',
                'name' => '使用教程',
            ),
            11 =>
            array(
                'id' => 12,
                'category_id' => 10,
                'locale' => 'zh-CN',
                'name' => '用户协议',
            ),
            12 =>
            array(
                'id' => 13,
                'category_id' => 11,
                'locale' => 'zh-CN',
                'name' => '隐私条款',
            ),
            13 =>
            array(
                'id' => 14,
                'category_id' => 12,
                'locale' => 'zh-CN',
                'name' => '推广奖励计划',
            ),
            14 =>
            array(
                'id' => 15,
                'category_id' => 13,
                'locale' => 'zh-CN',
                'name' => '费率标准',
            ),
            15 =>
            array(
                'id' => 16,
                'category_id' => 18,
                'locale' => 'zh-CN',
                'name' => '新手教程',
            ),
            16 =>
            array(
                'id' => 17,
                'category_id' => 19,
                'locale' => 'zh-CN',
                'name' => '联系我们',
            ),
            17 =>
            array(
                'id' => 18,
                'category_id' => 20,
                'locale' => 'zh-CN',
                'name' => '图标简介',
            ),
            18 =>
            array(
                'id' => 19,
                'category_id' => 21,
                'locale' => 'zh-CN',
                'name' => '交易策略',
            ),
            19 =>
            array(
                'id' => 20,
                'category_id' => 22,
                'locale' => 'zh-CN',
                'name' => '行业研究',
            ),
            20 =>
            array(
                'id' => 21,
                'category_id' => 23,
                'locale' => 'zh-CN',
                'name' => '秒懂币币交易',
            ),
            21 =>
            array(
                'id' => 22,
                'category_id' => 24,
                'locale' => 'zh-CN',
                'name' => '1分钟购买一笔比特币',
            ),
            22 =>
            array(
                'id' => 23,
                'category_id' => 25,
                'locale' => 'zh-CN',
                'name' => '合约交易入门',
            ),
            23 =>
            array(
                'id' => 24,
                'category_id' => 26,
                'locale' => 'zh-CN',
                'name' => '如何进行期权交易',
            ),
            24 =>
            array(
                'id' => 25,
                'category_id' => 27,
                'locale' => 'zh-CN',
                'name' => '法律声明',
            ),
            25 =>
            array(
                'id' => 26,
                'category_id' => 28,
                'locale' => 'zh-CN',
                'name' => '关于',
            ),
            26 =>
            array(
                'id' => 27,
                'category_id' => 29,
                'locale' => 'zh-CN',
                'name' => '关于我们',
            ),
            27 =>
            array(
                'id' => 28,
                'category_id' => 30,
                'locale' => 'zh-CN',
                'name' => '市场动态',
            ),
            28 =>
            array(
                'id' => 29,
                'category_id' => 31,
                'locale' => 'zh-CN',
                'name' => '版权信息',
            ),
            29 =>
            array(
                'id' => 30,
                'category_id' => 1,
                'locale' => 'zh-CN',
                'name' => '行业资讯',
            ),
            30 =>
            array(
                'id' => 31,
                'category_id' => 1,
                'locale' => 'en',
                'name' => 'Industry News',
            ),
            31 =>
            array(
                'id' => 32,
                'category_id' => 4,
                'locale' => 'en',
                'name' => 'System Notice',
            ),
            32 =>
            array(
                'id' => 33,
                'category_id' => 31,
                'locale' => 'en',
                'name' => 'Copyright',
            ),
            33 =>
            array(
                'id' => 34,
                'category_id' => 5,
                'locale' => 'en',
                'name' => 'College',
            ),
            34 =>
            array(
                'id' => 35,
                'category_id' => 20,
                'locale' => 'en',
                'name' => 'Icon',
            ),
            35 =>
            array(
                'id' => 36,
                'category_id' => 28,
                'locale' => 'en',
                'name' => 'As Regards',
            ),
            36 =>
            array(
                'id' => 37,
                'category_id' => 13,
                'locale' => 'en',
                'name' => 'Standard Rate',
            ),
            37 =>
            array(
                'id' => 38,
                'category_id' => 18,
                'locale' => 'en',
                'name' => 'Beginners Guide',
            ),
            38 =>
            array(
                'id' => 39,
                'category_id' => 21,
                'locale' => 'en',
                'name' => 'Trading Strategy',
            ),
            39 =>
            array(
                'id' => 40,
                'category_id' => 22,
                'locale' => 'en',
                'name' => 'Industry Research',
            ),
            40 =>
            array(
                'id' => 41,
                'category_id' => 30,
                'locale' => 'en',
                'name' => 'Market News',
            ),
            41 =>
            array(
                'id' => 42,
                'category_id' => 29,
                'locale' => 'en',
                'name' => 'About Us',
            ),
            42 =>
            array(
                'id' => 43,
                'category_id' => 19,
                'locale' => 'en',
                'name' => 'Contact Us',
            ),
            43 =>
            array(
                'id' => 44,
                'category_id' => 12,
                'locale' => 'en',
                'name' => 'Promotion Award Scheme',
            ),
            44 =>
            array(
                'id' => 45,
                'category_id' => 9,
                'locale' => 'en',
                'name' => 'Tutorial',
            ),
            45 =>
            array(
                'id' => 46,
                'category_id' => 8,
                'locale' => 'en',
                'name' => 'FAQ',
            ),
            46 =>
            array(
                'id' => 47,
                'category_id' => 5,
                'locale' => 'zh-TW',
                'name' => '學院',
            ),
            47 =>
            array(
                'id' => 48,
                'category_id' => 24,
                'locale' => 'en',
                'name' => 'Buy one bitcoin per minute',
            ),
            48 =>
            array(
                'id' => 49,
                'category_id' => 24,
                'locale' => 'zh-TW',
                'name' => '1分鍾購買一筆比特幣',
            ),
            49 =>
            array(
                'id' => 50,
                'category_id' => 23,
                'locale' => 'en',
                'name' => 'Second to understand the currency exchange',
            ),
            50 =>
            array(
                'id' => 51,
                'category_id' => 23,
                'locale' => 'zh-TW',
                'name' => '秒懂幣幣交易',
            ),
            51 =>
            array(
                'id' => 52,
                'category_id' => 25,
                'locale' => 'en',
                'name' => 'Introduction to Contract Trading',
            ),
            52 =>
            array(
                'id' => 53,
                'category_id' => 25,
                'locale' => 'zh-TW',
                'name' => '合約交易入門',
            ),
            53 =>
            array(
                'id' => 54,
                'category_id' => 26,
                'locale' => 'en',
                'name' => 'How to trade options',
            ),
            54 =>
            array(
                'id' => 55,
                'category_id' => 26,
                'locale' => 'zh-TW',
                'name' => '如何進行期權交易',
            ),
            55 =>
            array(
                'id' => 56,
                'category_id' => 18,
                'locale' => 'zh-TW',
                'name' => '新手教程',
            ),
            56 =>
            array(
                'id' => 57,
                'category_id' => 21,
                'locale' => 'zh-TW',
                'name' => '交易策略',
            ),
            57 =>
            array(
                'id' => 58,
                'category_id' => 22,
                'locale' => 'zh-TW',
                'name' => '行業研究',
            ),
            58 =>
            array(
                'id' => 59,
                'category_id' => 32,
                'locale' => 'zh-CN',
                'name' => '市场动态',
            ),
            59 =>
            array(
                'id' => 60,
                'category_id' => 32,
                'locale' => 'en',
                'name' => 'Market News',
            ),
            60 =>
            array(
                'id' => 61,
                'category_id' => 32,
                'locale' => 'zh-TW',
                'name' => '市場動態',
            ),
            61 =>
            array(
                'id' => 62,
                'category_id' => 33,
                'locale' => 'zh-CN',
                'name' => '关于我们',
            ),
            62 =>
            array(
                'id' => 63,
                'category_id' => 33,
                'locale' => 'en',
                'name' => 'About Us',
            ),
            63 =>
            array(
                'id' => 64,
                'category_id' => 33,
                'locale' => 'zh-TW',
                'name' => '關於我們',
            ),
            64 =>
            array(
                'id' => 65,
                'category_id' => 34,
                'locale' => 'zh-CN',
                'name' => '联系我们',
            ),
            65 =>
            array(
                'id' => 66,
                'category_id' => 34,
                'locale' => 'en',
                'name' => 'Contact Us',
            ),
            66 =>
            array(
                'id' => 67,
                'category_id' => 34,
                'locale' => 'zh-TW',
                'name' => '聯系我們',
            ),
            67 =>
            array(
                'id' => 68,
                'category_id' => 11,
                'locale' => 'en',
                'name' => 'Privacy policy',
            ),
            68 =>
            array(
                'id' => 69,
                'category_id' => 11,
                'locale' => 'zh-TW',
                'name' => '隱私條款',
            ),
            69 =>
            array(
                'id' => 70,
                'category_id' => 27,
                'locale' => 'zh-TW',
                'name' => '法律聲明',
            ),
            70 =>
            array(
                'id' => 71,
                'category_id' => 27,
                'locale' => 'en',
                'name' => 'Legal Notice',
            ),
            71 =>
            array(
                'id' => 72,
                'category_id' => 10,
                'locale' => 'en',
                'name' => 'User Agreement',
            ),
            72 =>
            array(
                'id' => 73,
                'category_id' => 10,
                'locale' => 'zh-TW',
                'name' => '用戶協議',
            ),
            73 =>
            array(
                'id' => 74,
                'category_id' => 35,
                'locale' => 'zh-CN',
                'name' => '等级说明',
            ),
            74 =>
            array(
                'id' => 75,
                'category_id' => 35,
                'locale' => 'en',
                'name' => 'Grade explain',
            ),
            75 =>
            array(
                'id' => 76,
                'category_id' => 35,
                'locale' => 'zh-TW',
                'name' => '等級說明',
            ),
            76 =>
            array(
                'id' => 77,
                'category_id' => 36,
                'locale' => 'zh-CN',
                'name' => '合约协议',
            ),
            77 =>
            array(
                'id' => 78,
                'category_id' => 36,
                'locale' => 'zh-TW',
                'name' => '合約協議',
            ),
            78 =>
            array(
                'id' => 79,
                'category_id' => 36,
                'locale' => 'en',
                'name' => 'The contract agreement',
            ),
        ));
    }
}
