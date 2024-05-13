<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('country')->delete();

        DB::table('country')->insert(array(
            0 =>
            array(
                'id' => 1,
                'code' => 'CN',
                'name' => '中国',
                'country_code' => '86',
                'order' => 255,
                'en_name' => 'China',
            ),
            1 =>
            array(
                'id' => 2,
                'code' => 'AE',
                'name' => '阿拉伯联合酋长国',
                'country_code' => '971',
                'order' => 255,
                'en_name' => 'United Arab Emirates',
            ),
            2 =>
            array(
                'id' => 3,
                'code' => 'AF',
                'name' => '阿富汗',
                'country_code' => '93',
                'order' => 255,
                'en_name' => 'Afghanistan',
            ),
            3 =>
            array(
                'id' => 4,
                'code' => 'AG',
                'name' => '安提瓜和巴布达',
                'country_code' => '1268',
                'order' => 255,
                'en_name' => 'Antigua and Barbuda',
            ),
            4 =>
            array(
                'id' => 5,
                'code' => 'AI',
                'name' => '安圭拉岛',
                'country_code' => '1264',
                'order' => 255,
                'en_name' => 'Anguilla',
            ),
            5 =>
            array(
                'id' => 6,
                'code' => 'AL',
                'name' => '阿尔巴尼亚',
                'country_code' => '355',
                'order' => 255,
                'en_name' => 'Albania',
            ),
            6 =>
            array(
                'id' => 7,
                'code' => 'AM',
                'name' => '亚美尼亚',
                'country_code' => '374',
                'order' => 255,
                'en_name' => 'Armenia',
            ),
            7 =>
            array(
                'id' => 8,
                'code' => '',
                'name' => '阿森松',
                'country_code' => '247',
                'order' => 255,
                'en_name' => 'Ascension',
            ),
            8 =>
            array(
                'id' => 9,
                'code' => 'AO',
                'name' => '安哥拉',
                'country_code' => '244',
                'order' => 255,
                'en_name' => 'Angola',
            ),
            9 =>
            array(
                'id' => 10,
                'code' => 'AR',
                'name' => '阿根廷',
                'country_code' => '54',
                'order' => 255,
                'en_name' => 'Argentina',
            ),
            10 =>
            array(
                'id' => 11,
                'code' => 'AT',
                'name' => '奥地利',
                'country_code' => '43',
                'order' => 255,
                'en_name' => 'Austria',
            ),
            11 =>
            array(
                'id' => 12,
                'code' => 'AU',
                'name' => '澳大利亚',
                'country_code' => '61',
                'order' => 255,
                'en_name' => 'Australia',
            ),
            12 =>
            array(
                'id' => 13,
                'code' => 'AZ',
                'name' => '阿塞拜疆',
                'country_code' => '994',
                'order' => 255,
                'en_name' => 'Azerbaijan',
            ),
            13 =>
            array(
                'id' => 14,
                'code' => 'BB',
                'name' => '巴巴多斯',
                'country_code' => '1246',
                'order' => 255,
                'en_name' => 'Barbados',
            ),
            14 =>
            array(
                'id' => 15,
                'code' => 'BD',
                'name' => '孟加拉国',
                'country_code' => '880',
                'order' => 255,
                'en_name' => 'Bangladesh',
            ),
            15 =>
            array(
                'id' => 16,
                'code' => 'BE',
                'name' => '比利时',
                'country_code' => '32',
                'order' => 255,
                'en_name' => 'Belgium',
            ),
            16 =>
            array(
                'id' => 17,
                'code' => 'BF',
                'name' => '布基纳法索',
                'country_code' => '226',
                'order' => 255,
                'en_name' => 'Burkina Faso',
            ),
            17 =>
            array(
                'id' => 18,
                'code' => 'BG',
                'name' => '保加利亚',
                'country_code' => '359',
                'order' => 255,
                'en_name' => 'Bulgaria',
            ),
            18 =>
            array(
                'id' => 19,
                'code' => 'BH',
                'name' => '巴林',
                'country_code' => '973',
                'order' => 255,
                'en_name' => 'Bahrain',
            ),
            19 =>
            array(
                'id' => 20,
                'code' => 'BI',
                'name' => '布隆迪',
                'country_code' => '257',
                'order' => 255,
                'en_name' => 'Burundi',
            ),
            20 =>
            array(
                'id' => 21,
                'code' => 'BJ',
                'name' => '贝宁',
                'country_code' => '229',
                'order' => 255,
                'en_name' => 'Benin',
            ),
            21 =>
            array(
                'id' => 22,
                'code' => 'BL',
                'name' => '巴勒斯坦',
                'country_code' => '970',
                'order' => 255,
                'en_name' => 'Palestine',
            ),
            22 =>
            array(
                'id' => 23,
                'code' => 'BM',
                'name' => '百慕大群岛',
                'country_code' => '1441',
                'order' => 255,
                'en_name' => 'Bermuda',
            ),
            23 =>
            array(
                'id' => 24,
                'code' => 'BN',
                'name' => '文莱',
                'country_code' => '673',
                'order' => 255,
                'en_name' => 'Brunei',
            ),
            24 =>
            array(
                'id' => 25,
                'code' => 'BO',
                'name' => '玻利维亚',
                'country_code' => '591',
                'order' => 255,
                'en_name' => 'Bolivia',
            ),
            25 =>
            array(
                'id' => 26,
                'code' => 'BR',
                'name' => '巴西',
                'country_code' => '55',
                'order' => 255,
                'en_name' => 'Brazil',
            ),
            26 =>
            array(
                'id' => 27,
                'code' => 'BS',
                'name' => '巴哈马',
                'country_code' => '1242',
                'order' => 255,
                'en_name' => 'Bahamas',
            ),
            27 =>
            array(
                'id' => 28,
                'code' => 'BW',
                'name' => '博茨瓦纳',
                'country_code' => '267',
                'order' => 255,
                'en_name' => 'Botswana',
            ),
            28 =>
            array(
                'id' => 29,
                'code' => 'BY',
                'name' => '白俄罗斯',
                'country_code' => '375',
                'order' => 255,
                'en_name' => 'Belarus',
            ),
            29 =>
            array(
                'id' => 30,
                'code' => 'BZ',
                'name' => '伯利兹',
                'country_code' => '501',
                'order' => 255,
                'en_name' => 'Belize',
            ),
            30 =>
            array(
                'id' => 31,
                'code' => 'CA',
                'name' => '加拿大',
                'country_code' => '1',
                'order' => 255,
                'en_name' => 'Canada',
            ),
            31 =>
            array(
                'id' => 32,
                'code' => '',
                'name' => '开曼群岛',
                'country_code' => '1345',
                'order' => 255,
                'en_name' => 'Cayman Islands',
            ),
            32 =>
            array(
                'id' => 33,
                'code' => 'CF',
                'name' => '中非共和国',
                'country_code' => '236',
                'order' => 255,
                'en_name' => 'Central African Republic',
            ),
            33 =>
            array(
                'id' => 34,
                'code' => 'CG',
                'name' => '刚果',
                'country_code' => '242',
                'order' => 255,
                'en_name' => 'Congo',
            ),
            34 =>
            array(
                'id' => 35,
                'code' => 'CH',
                'name' => '瑞士',
                'country_code' => '41',
                'order' => 255,
                'en_name' => 'Switzerland',
            ),
            35 =>
            array(
                'id' => 36,
                'code' => 'CK',
                'name' => '库克群岛',
                'country_code' => '682',
                'order' => 255,
                'en_name' => 'Island',
            ),
            36 =>
            array(
                'id' => 37,
                'code' => 'CL',
                'name' => '智利',
                'country_code' => '56',
                'order' => 255,
                'en_name' => 'Chile',
            ),
            37 =>
            array(
                'id' => 38,
                'code' => 'CM',
                'name' => '喀麦隆',
                'country_code' => '237',
                'order' => 255,
                'en_name' => 'Cameroon',
            ),
            38 =>
            array(
                'id' => 40,
                'code' => 'CO',
                'name' => '哥伦比亚',
                'country_code' => '57',
                'order' => 255,
                'en_name' => 'Colombia',
            ),
            39 =>
            array(
                'id' => 41,
                'code' => 'CR',
                'name' => '哥斯达黎加',
                'country_code' => '506',
                'order' => 255,
                'en_name' => 'Costa Rica',
            ),
            40 =>
            array(
                'id' => 42,
                'code' => 'CS',
                'name' => '捷克',
                'country_code' => '420',
                'order' => 255,
                'en_name' => 'Czech Republic',
            ),
            41 =>
            array(
                'id' => 43,
                'code' => 'CU',
                'name' => '古巴',
                'country_code' => '53',
                'order' => 255,
                'en_name' => 'Cuba',
            ),
            42 =>
            array(
                'id' => 44,
                'code' => 'CY',
                'name' => '塞浦路斯',
                'country_code' => '357',
                'order' => 255,
                'en_name' => 'Cyprus',
            ),
            43 =>
            array(
                'id' => 46,
                'code' => 'DE',
                'name' => '德国',
                'country_code' => '49',
                'order' => 255,
                'en_name' => 'Germany',
            ),
            44 =>
            array(
                'id' => 47,
                'code' => 'DJ',
                'name' => '吉布提',
                'country_code' => '253',
                'order' => 255,
                'en_name' => 'Djibouti',
            ),
            45 =>
            array(
                'id' => 48,
                'code' => 'DK',
                'name' => '丹麦',
                'country_code' => '45',
                'order' => 255,
                'en_name' => 'Denmark',
            ),
            46 =>
            array(
                'id' => 49,
                'code' => 'DO',
                'name' => '多米尼加共和国',
                'country_code' => '1890',
                'order' => 255,
                'en_name' => 'Dominican Republic',
            ),
            47 =>
            array(
                'id' => 50,
                'code' => 'DZ',
                'name' => '阿尔及利亚',
                'country_code' => '213',
                'order' => 255,
                'en_name' => 'Algeria',
            ),
            48 =>
            array(
                'id' => 51,
                'code' => 'EC',
                'name' => '厄瓜多尔',
                'country_code' => '593',
                'order' => 255,
                'en_name' => 'Ecuador',
            ),
            49 =>
            array(
                'id' => 52,
                'code' => 'EE',
                'name' => '爱沙尼亚',
                'country_code' => '372',
                'order' => 255,
                'en_name' => 'Estonia',
            ),
            50 =>
            array(
                'id' => 53,
                'code' => 'EG',
                'name' => '埃及',
                'country_code' => '20',
                'order' => 255,
                'en_name' => 'Egypt',
            ),
            51 =>
            array(
                'id' => 54,
                'code' => 'ES',
                'name' => '西班牙',
                'country_code' => '34',
                'order' => 255,
                'en_name' => 'Spain',
            ),
            52 =>
            array(
                'id' => 55,
                'code' => 'ET',
                'name' => '埃塞俄比亚',
                'country_code' => '251',
                'order' => 255,
                'en_name' => 'Ethiopia',
            ),
            53 =>
            array(
                'id' => 56,
                'code' => 'FI',
                'name' => '芬兰',
                'country_code' => '358',
                'order' => 255,
                'en_name' => 'Finland',
            ),
            54 =>
            array(
                'id' => 57,
                'code' => 'FJ',
                'name' => '斐济',
                'country_code' => '679',
                'order' => 255,
                'en_name' => 'Fiji',
            ),
            55 =>
            array(
                'id' => 58,
                'code' => 'FR',
                'name' => '法国',
                'country_code' => '33',
                'order' => 255,
                'en_name' => 'France',
            ),
            56 =>
            array(
                'id' => 59,
                'code' => 'GA',
                'name' => '加蓬',
                'country_code' => '241',
                'order' => 255,
                'en_name' => 'Gabon',
            ),
            57 =>
            array(
                'id' => 60,
                'code' => 'GB',
                'name' => '英国',
                'country_code' => '44',
                'order' => 255,
                'en_name' => 'United Kingdom',
            ),
            58 =>
            array(
                'id' => 61,
                'code' => 'GD',
                'name' => '格林纳达',
                'country_code' => '1473',
                'order' => 255,
                'en_name' => 'Grenada',
            ),
            59 =>
            array(
                'id' => 62,
                'code' => 'GE',
                'name' => '格鲁吉亚',
                'country_code' => '995',
                'order' => 255,
                'en_name' => 'Georgia',
            ),
            60 =>
            array(
                'id' => 63,
                'code' => 'GF',
                'name' => '法属圭亚那',
                'country_code' => '594',
                'order' => 255,
                'en_name' => 'French Guiana',
            ),
            61 =>
            array(
                'id' => 64,
                'code' => 'GH',
                'name' => '加纳',
                'country_code' => '233',
                'order' => 255,
                'en_name' => 'Ghana',
            ),
            62 =>
            array(
                'id' => 65,
                'code' => 'GI',
                'name' => '直布罗陀',
                'country_code' => '350',
                'order' => 255,
                'en_name' => 'Gibraltar',
            ),
            63 =>
            array(
                'id' => 66,
                'code' => 'GM',
                'name' => '冈比亚',
                'country_code' => '220',
                'order' => 255,
                'en_name' => 'Gambia',
            ),
            64 =>
            array(
                'id' => 67,
                'code' => 'GN',
                'name' => '几内亚',
                'country_code' => '224',
                'order' => 255,
                'en_name' => 'Guinea',
            ),
            65 =>
            array(
                'id' => 68,
                'code' => 'GR',
                'name' => '希腊',
                'country_code' => '30',
                'order' => 255,
                'en_name' => 'Greece',
            ),
            66 =>
            array(
                'id' => 69,
                'code' => 'GT',
                'name' => '危地马拉',
                'country_code' => '502',
                'order' => 255,
                'en_name' => 'Guatemala',
            ),
            67 =>
            array(
                'id' => 70,
                'code' => 'GU',
                'name' => '关岛',
                'country_code' => '1671',
                'order' => 255,
                'en_name' => 'Guam',
            ),
            68 =>
            array(
                'id' => 71,
                'code' => 'GY',
                'name' => '圭亚那',
                'country_code' => '592',
                'order' => 255,
                'en_name' => 'Guyana',
            ),
            69 =>
            array(
                'id' => 72,
                'code' => 'HK',
                'name' => '香港特别行政区',
                'country_code' => '852',
                'order' => 255,
                'en_name' => 'Hong Kong Special Administrative Region',
            ),
            70 =>
            array(
                'id' => 73,
                'code' => 'HN',
                'name' => '洪都拉斯',
                'country_code' => '504',
                'order' => 255,
                'en_name' => 'Honduras',
            ),
            71 =>
            array(
                'id' => 74,
                'code' => 'HT',
                'name' => '海地',
                'country_code' => '509',
                'order' => 255,
                'en_name' => 'Haiti',
            ),
            72 =>
            array(
                'id' => 75,
                'code' => 'HU',
                'name' => '匈牙利',
                'country_code' => '36',
                'order' => 255,
                'en_name' => 'Hungary',
            ),
            73 =>
            array(
                'id' => 76,
                'code' => 'ID',
                'name' => '印度尼西亚',
                'country_code' => '62',
                'order' => 255,
                'en_name' => 'Indonesia',
            ),
            74 =>
            array(
                'id' => 77,
                'code' => 'IE',
                'name' => '爱尔兰',
                'country_code' => '353',
                'order' => 255,
                'en_name' => 'Ireland',
            ),
            75 =>
            array(
                'id' => 78,
                'code' => 'IL',
                'name' => '以色列',
                'country_code' => '972',
                'order' => 255,
                'en_name' => 'Israel',
            ),
            76 =>
            array(
                'id' => 79,
                'code' => 'IN',
                'name' => '印度',
                'country_code' => '91',
                'order' => 255,
                'en_name' => 'India',
            ),
            77 =>
            array(
                'id' => 80,
                'code' => 'IQ',
                'name' => '伊拉克',
                'country_code' => '964',
                'order' => 255,
                'en_name' => 'Iraq',
            ),
            78 =>
            array(
                'id' => 81,
                'code' => 'IR',
                'name' => '伊朗',
                'country_code' => '98',
                'order' => 255,
                'en_name' => 'Iran',
            ),
            79 =>
            array(
                'id' => 82,
                'code' => 'IS',
                'name' => '冰岛',
                'country_code' => '354',
                'order' => 255,
                'en_name' => 'Iceland',
            ),
            80 =>
            array(
                'id' => 83,
                'code' => 'IT',
                'name' => '意大利',
                'country_code' => '39',
                'order' => 255,
                'en_name' => 'Italy',
            ),
            81 =>
            array(
                'id' => 85,
                'code' => 'JM',
                'name' => '牙买加',
                'country_code' => '1876',
                'order' => 255,
                'en_name' => 'Jamaica',
            ),
            82 =>
            array(
                'id' => 86,
                'code' => 'JO',
                'name' => '约旦',
                'country_code' => '962',
                'order' => 255,
                'en_name' => 'Jordan',
            ),
            83 =>
            array(
                'id' => 87,
                'code' => 'JP',
                'name' => '日本',
                'country_code' => '81',
                'order' => 255,
                'en_name' => 'Japan',
            ),
            84 =>
            array(
                'id' => 88,
                'code' => 'KE',
                'name' => '肯尼亚',
                'country_code' => '254',
                'order' => 255,
                'en_name' => 'Kenya',
            ),
            85 =>
            array(
                'id' => 89,
                'code' => 'KG',
                'name' => '吉尔吉斯坦',
                'country_code' => '331',
                'order' => 255,
                'en_name' => 'Kyrgyzstan',
            ),
            86 =>
            array(
                'id' => 90,
                'code' => 'KH',
                'name' => '柬埔寨',
                'country_code' => '855',
                'order' => 255,
                'en_name' => 'Cambodia',
            ),
            87 =>
            array(
                'id' => 91,
                'code' => 'KP',
                'name' => '朝鲜',
                'country_code' => '850',
                'order' => 255,
                'en_name' => 'Korea',
            ),
            88 =>
            array(
                'id' => 92,
                'code' => 'KR',
                'name' => '韩国',
                'country_code' => '82',
                'order' => 255,
                'en_name' => 'Korea',
            ),
            89 =>
            array(
                'id' => 93,
                'code' => 'KT',
                'name' => '科特迪瓦共和国',
                'country_code' => '225',
                'order' => 255,
                'en_name' => 'Republic of Cote d\'Ivoire',
            ),
            90 =>
            array(
                'id' => 94,
                'code' => 'KW',
                'name' => '科威特',
                'country_code' => '965',
                'order' => 255,
                'en_name' => 'Kuwait',
            ),
            91 =>
            array(
                'id' => 95,
                'code' => 'KZ',
                'name' => '哈萨克斯坦',
                'country_code' => '327',
                'order' => 255,
                'en_name' => 'Kazakhstan',
            ),
            92 =>
            array(
                'id' => 96,
                'code' => 'LA',
                'name' => '老挝',
                'country_code' => '856',
                'order' => 255,
                'en_name' => 'Laos',
            ),
            93 =>
            array(
                'id' => 97,
                'code' => 'LB',
                'name' => '黎巴嫩',
                'country_code' => '961',
                'order' => 255,
                'en_name' => 'Lebanon',
            ),
            94 =>
            array(
                'id' => 98,
                'code' => 'LC',
                'name' => '圣卢西亚',
                'country_code' => '1758',
                'order' => 255,
                'en_name' => 'Saint Lucia',
            ),
            95 =>
            array(
                'id' => 99,
                'code' => 'LI',
                'name' => '列支敦士登',
                'country_code' => '423',
                'order' => 255,
                'en_name' => 'Liechtenstein',
            ),
            96 =>
            array(
                'id' => 100,
                'code' => 'LK',
                'name' => '斯里兰卡',
                'country_code' => '94',
                'order' => 255,
                'en_name' => 'Sri Lanka',
            ),
            97 =>
            array(
                'id' => 101,
                'code' => 'LR',
                'name' => '利比里亚',
                'country_code' => '231',
                'order' => 255,
                'en_name' => 'Liberia',
            ),
            98 =>
            array(
                'id' => 102,
                'code' => 'LS',
                'name' => '莱索托',
                'country_code' => '266',
                'order' => 255,
                'en_name' => 'Lesotho',
            ),
            99 =>
            array(
                'id' => 103,
                'code' => 'LT',
                'name' => '立陶宛',
                'country_code' => '370',
                'order' => 255,
                'en_name' => 'Lithuania',
            ),
            100 =>
            array(
                'id' => 104,
                'code' => 'LU',
                'name' => '卢森堡',
                'country_code' => '352',
                'order' => 255,
                'en_name' => 'Luxembourg',
            ),
            101 =>
            array(
                'id' => 105,
                'code' => 'LV',
                'name' => '拉脱维亚',
                'country_code' => '371',
                'order' => 255,
                'en_name' => 'Latvia',
            ),
            102 =>
            array(
                'id' => 106,
                'code' => 'LY',
                'name' => '利比亚',
                'country_code' => '218',
                'order' => 255,
                'en_name' => 'Libya',
            ),
            103 =>
            array(
                'id' => 107,
                'code' => 'MA',
                'name' => '摩洛哥',
                'country_code' => '212',
                'order' => 255,
                'en_name' => 'Morocco',
            ),
            104 =>
            array(
                'id' => 108,
                'code' => 'MC',
                'name' => '摩纳哥',
                'country_code' => '377',
                'order' => 255,
                'en_name' => 'Monaco',
            ),
            105 =>
            array(
                'id' => 109,
                'code' => 'MD',
                'name' => '摩尔多瓦',
                'country_code' => '373',
                'order' => 255,
                'en_name' => 'Moldova',
            ),
            106 =>
            array(
                'id' => 110,
                'code' => 'MG',
                'name' => '马达加斯加',
                'country_code' => '261',
                'order' => 255,
                'en_name' => 'Madagascar',
            ),
            107 =>
            array(
                'id' => 111,
                'code' => 'ML',
                'name' => '马里',
                'country_code' => '223',
                'order' => 255,
                'en_name' => 'Mali',
            ),
            108 =>
            array(
                'id' => 112,
                'code' => 'MM',
                'name' => '缅甸',
                'country_code' => '95',
                'order' => 255,
                'en_name' => 'Myanmar',
            ),
            109 =>
            array(
                'id' => 113,
                'code' => 'MN',
                'name' => '蒙古',
                'country_code' => '976',
                'order' => 255,
                'en_name' => 'Mongolia',
            ),
            110 =>
            array(
                'id' => 114,
                'code' => 'MO',
                'name' => '澳门',
                'country_code' => '853',
                'order' => 255,
                'en_name' => 'Macao',
            ),
            111 =>
            array(
                'id' => 115,
                'code' => 'MS',
                'name' => '蒙特塞拉特岛',
                'country_code' => '1664',
                'order' => 255,
                'en_name' => 'Montserrat',
            ),
            112 =>
            array(
                'id' => 116,
                'code' => 'MT',
                'name' => '马耳他',
                'country_code' => '356',
                'order' => 255,
                'en_name' => 'Malta',
            ),
            113 =>
            array(
                'id' => 117,
                'code' => '',
                'name' => '马里亚那群岛',
                'country_code' => '1670',
                'order' => 255,
                'en_name' => 'Mariana Islands',
            ),
            114 =>
            array(
                'id' => 118,
                'code' => '',
                'name' => '马提尼克',
                'country_code' => '596',
                'order' => 255,
                'en_name' => 'Martinique',
            ),
            115 =>
            array(
                'id' => 119,
                'code' => 'MU',
                'name' => '毛里求斯',
                'country_code' => '230',
                'order' => 255,
                'en_name' => 'Mauritius',
            ),
            116 =>
            array(
                'id' => 120,
                'code' => 'MV',
                'name' => '马尔代夫',
                'country_code' => '960',
                'order' => 255,
                'en_name' => 'Maldives',
            ),
            117 =>
            array(
                'id' => 121,
                'code' => 'MW',
                'name' => '马拉维',
                'country_code' => '265',
                'order' => 255,
                'en_name' => 'Malawi',
            ),
            118 =>
            array(
                'id' => 122,
                'code' => 'MX',
                'name' => '墨西哥',
                'country_code' => '52',
                'order' => 255,
                'en_name' => 'Mexico',
            ),
            119 =>
            array(
                'id' => 123,
                'code' => 'MY',
                'name' => '马来西亚',
                'country_code' => '60',
                'order' => 255,
                'en_name' => 'Malaysia',
            ),
            120 =>
            array(
                'id' => 124,
                'code' => 'MZ',
                'name' => '莫桑比克',
                'country_code' => '258',
                'order' => 255,
                'en_name' => 'Mozambique',
            ),
            121 =>
            array(
                'id' => 125,
                'code' => 'NA',
                'name' => '纳米比亚',
                'country_code' => '264',
                'order' => 255,
                'en_name' => 'Namibia',
            ),
            122 =>
            array(
                'id' => 126,
                'code' => 'NE',
                'name' => '尼日尔',
                'country_code' => '227',
                'order' => 255,
                'en_name' => 'Niger',
            ),
            123 =>
            array(
                'id' => 127,
                'code' => 'NG',
                'name' => '尼日利亚',
                'country_code' => '234',
                'order' => 255,
                'en_name' => 'Nigeria',
            ),
            124 =>
            array(
                'id' => 128,
                'code' => 'NI',
                'name' => '尼加拉瓜',
                'country_code' => '505',
                'order' => 255,
                'en_name' => 'Nicaragua',
            ),
            125 =>
            array(
                'id' => 129,
                'code' => 'NL',
                'name' => '荷兰',
                'country_code' => '31',
                'order' => 255,
                'en_name' => 'Netherlands',
            ),
            126 =>
            array(
                'id' => 130,
                'code' => 'NO',
                'name' => '挪威',
                'country_code' => '47',
                'order' => 255,
                'en_name' => 'Norway',
            ),
            127 =>
            array(
                'id' => 131,
                'code' => 'NP',
                'name' => '尼泊尔',
                'country_code' => '977',
                'order' => 255,
                'en_name' => 'Nepal',
            ),
            128 =>
            array(
                'id' => 132,
                'code' => '',
                'name' => '荷属安的列斯',
                'country_code' => '599',
                'order' => 255,
                'en_name' => 'Netherlands Antilles',
            ),
            129 =>
            array(
                'id' => 133,
                'code' => 'NR',
                'name' => '瑙鲁',
                'country_code' => '674',
                'order' => 255,
                'en_name' => 'Nauru',
            ),
            130 =>
            array(
                'id' => 134,
                'code' => 'NZ',
                'name' => '新西兰',
                'country_code' => '64',
                'order' => 255,
                'en_name' => 'new Zealand',
            ),
            131 =>
            array(
                'id' => 135,
                'code' => 'OM',
                'name' => '阿曼',
                'country_code' => '968',
                'order' => 255,
                'en_name' => 'Oman',
            ),
            132 =>
            array(
                'id' => 136,
                'code' => 'PA',
                'name' => '巴拿马',
                'country_code' => '507',
                'order' => 255,
                'en_name' => 'Panama',
            ),
            133 =>
            array(
                'id' => 137,
                'code' => 'PE',
                'name' => '秘鲁',
                'country_code' => '51',
                'order' => 255,
                'en_name' => 'Peru',
            ),
            134 =>
            array(
                'id' => 138,
                'code' => 'PF',
                'name' => '法属玻利尼西亚',
                'country_code' => '689',
                'order' => 255,
                'en_name' => 'French Polynesia',
            ),
            135 =>
            array(
                'id' => 139,
                'code' => 'PG',
                'name' => '巴布亚新几内亚',
                'country_code' => '675',
                'order' => 255,
                'en_name' => 'Papua New Guinea',
            ),
            136 =>
            array(
                'id' => 140,
                'code' => 'PH',
                'name' => '菲律宾',
                'country_code' => '63',
                'order' => 255,
                'en_name' => 'Philippines',
            ),
            137 =>
            array(
                'id' => 141,
                'code' => 'PK',
                'name' => '巴基斯坦',
                'country_code' => '92',
                'order' => 255,
                'en_name' => 'Pakistan',
            ),
            138 =>
            array(
                'id' => 142,
                'code' => 'PL',
                'name' => '波兰',
                'country_code' => '48',
                'order' => 255,
                'en_name' => 'Poland',
            ),
            139 =>
            array(
                'id' => 143,
                'code' => 'PR',
                'name' => '波多黎各',
                'country_code' => '1787',
                'order' => 255,
                'en_name' => 'Puerto Rico',
            ),
            140 =>
            array(
                'id' => 144,
                'code' => 'PT',
                'name' => '葡萄牙',
                'country_code' => '351',
                'order' => 255,
                'en_name' => 'Portugal',
            ),
            141 =>
            array(
                'id' => 145,
                'code' => 'PY',
                'name' => '巴拉圭',
                'country_code' => '595',
                'order' => 255,
                'en_name' => 'Paraguay',
            ),
            142 =>
            array(
                'id' => 146,
                'code' => 'QA',
                'name' => '卡塔尔',
                'country_code' => '974',
                'order' => 255,
                'en_name' => 'Qatar',
            ),
            143 =>
            array(
                'id' => 147,
                'code' => '',
                'name' => '留尼旺',
                'country_code' => '262',
                'order' => 255,
                'en_name' => 'Reunion',
            ),
            144 =>
            array(
                'id' => 148,
                'code' => 'RO',
                'name' => '罗马尼亚',
                'country_code' => '40',
                'order' => 255,
                'en_name' => 'Romania',
            ),
            145 =>
            array(
                'id' => 149,
                'code' => 'RU',
                'name' => '俄罗斯',
                'country_code' => '7',
                'order' => 255,
                'en_name' => 'Russia',
            ),
            146 =>
            array(
                'id' => 150,
                'code' => 'SA',
                'name' => '沙特阿拉伯',
                'country_code' => '966',
                'order' => 255,
                'en_name' => 'Saudi Arabia',
            ),
            147 =>
            array(
                'id' => 151,
                'code' => 'SB',
                'name' => '所罗门群岛',
                'country_code' => '677',
                'order' => 255,
                'en_name' => 'Solomon Islands',
            ),
            148 =>
            array(
                'id' => 152,
                'code' => 'SC',
                'name' => '塞舌尔',
                'country_code' => '248',
                'order' => 255,
                'en_name' => 'Seychelles',
            ),
            149 =>
            array(
                'id' => 153,
                'code' => 'SD',
                'name' => '苏丹',
                'country_code' => '249',
                'order' => 255,
                'en_name' => 'Sudan',
            ),
            150 =>
            array(
                'id' => 154,
                'code' => 'SE',
                'name' => '瑞典',
                'country_code' => '46',
                'order' => 255,
                'en_name' => 'Sweden',
            ),
            151 =>
            array(
                'id' => 155,
                'code' => 'SG',
                'name' => '新加坡',
                'country_code' => '65',
                'order' => 255,
                'en_name' => 'Singapore',
            ),
            152 =>
            array(
                'id' => 156,
                'code' => 'SI',
                'name' => '斯洛文尼亚',
                'country_code' => '386',
                'order' => 255,
                'en_name' => 'Slovenia',
            ),
            153 =>
            array(
                'id' => 157,
                'code' => 'SK',
                'name' => '斯洛伐克',
                'country_code' => '421',
                'order' => 255,
                'en_name' => 'Slovakia',
            ),
            154 =>
            array(
                'id' => 158,
                'code' => 'SL',
                'name' => '塞拉利昂',
                'country_code' => '232',
                'order' => 255,
                'en_name' => 'Sierra Leone',
            ),
            155 =>
            array(
                'id' => 159,
                'code' => 'SM',
                'name' => '圣马力诺',
                'country_code' => '378',
                'order' => 255,
                'en_name' => 'San Marino',
            ),
            156 =>
            array(
                'id' => 160,
                'code' => '',
                'name' => '东萨摩亚(美)',
                'country_code' => '684',
                'order' => 255,
                'en_name' => 'Eastern Samoa (United States)',
            ),
            157 =>
            array(
                'id' => 161,
                'code' => '',
                'name' => '西萨摩亚',
                'country_code' => '685',
                'order' => 255,
                'en_name' => 'Western Samoa',
            ),
            158 =>
            array(
                'id' => 162,
                'code' => 'SN',
                'name' => '塞内加尔',
                'country_code' => '221',
                'order' => 255,
                'en_name' => 'Senegal',
            ),
            159 =>
            array(
                'id' => 163,
                'code' => 'SO',
                'name' => '索马里',
                'country_code' => '252',
                'order' => 255,
                'en_name' => 'Somalia',
            ),
            160 =>
            array(
                'id' => 164,
                'code' => 'SR',
                'name' => '苏里南',
                'country_code' => '597',
                'order' => 255,
                'en_name' => 'Suriname',
            ),
            161 =>
            array(
                'id' => 165,
                'code' => 'ST',
                'name' => '圣多美和普林西比',
                'country_code' => '239',
                'order' => 255,
                'en_name' => 'Sao Tome and Principe',
            ),
            162 =>
            array(
                'id' => 166,
                'code' => 'SV',
                'name' => '萨尔瓦多',
                'country_code' => '503',
                'order' => 255,
                'en_name' => 'Salvador',
            ),
            163 =>
            array(
                'id' => 167,
                'code' => 'SY',
                'name' => '叙利亚',
                'country_code' => '963',
                'order' => 255,
                'en_name' => 'Syria',
            ),
            164 =>
            array(
                'id' => 168,
                'code' => 'SZ',
                'name' => '斯威士兰',
                'country_code' => '268',
                'order' => 255,
                'en_name' => 'Swaziland',
            ),
            165 =>
            array(
                'id' => 169,
                'code' => 'TD',
                'name' => '乍得',
                'country_code' => '235',
                'order' => 255,
                'en_name' => 'Chad',
            ),
            166 =>
            array(
                'id' => 170,
                'code' => 'TG',
                'name' => '多哥',
                'country_code' => '228',
                'order' => 255,
                'en_name' => 'Togo',
            ),
            167 =>
            array(
                'id' => 171,
                'code' => 'TH',
                'name' => '泰国',
                'country_code' => '66',
                'order' => 255,
                'en_name' => 'Thailand',
            ),
            168 =>
            array(
                'id' => 172,
                'code' => 'TJ',
                'name' => '塔吉克斯坦',
                'country_code' => '992',
                'order' => 255,
                'en_name' => 'Tajikistan',
            ),
            169 =>
            array(
                'id' => 173,
                'code' => 'TM',
                'name' => '土库曼斯坦',
                'country_code' => '993',
                'order' => 255,
                'en_name' => 'Turkmenistan',
            ),
            170 =>
            array(
                'id' => 174,
                'code' => 'TN',
                'name' => '突尼斯',
                'country_code' => '216',
                'order' => 255,
                'en_name' => 'Tunisia',
            ),
            171 =>
            array(
                'id' => 175,
                'code' => 'TO',
                'name' => '汤加',
                'country_code' => '676',
                'order' => 255,
                'en_name' => 'Tonga',
            ),
            172 =>
            array(
                'id' => 176,
                'code' => 'TR',
                'name' => '土耳其',
                'country_code' => '90',
                'order' => 255,
                'en_name' => 'Turkey',
            ),
            173 =>
            array(
                'id' => 177,
                'code' => 'TT',
                'name' => '特立尼达和多巴哥',
                'country_code' => '1809',
                'order' => 255,
                'en_name' => 'Trinidad and Tobago',
            ),
            174 =>
            array(
                'id' => 178,
                'code' => 'TW',
                'name' => '台湾省',
                'country_code' => '886',
                'order' => 255,
                'en_name' => 'Taiwan Province',
            ),
            175 =>
            array(
                'id' => 179,
                'code' => 'TZ',
                'name' => '坦桑尼亚',
                'country_code' => '255',
                'order' => 255,
                'en_name' => 'Tanzania',
            ),
            176 =>
            array(
                'id' => 180,
                'code' => 'UA',
                'name' => '乌克兰',
                'country_code' => '380',
                'order' => 255,
                'en_name' => 'Ukraine',
            ),
            177 =>
            array(
                'id' => 181,
                'code' => 'UG',
                'name' => '乌干达',
                'country_code' => '256',
                'order' => 255,
                'en_name' => 'Uganda',
            ),
            178 =>
            array(
                'id' => 183,
                'code' => 'UY',
                'name' => '乌拉圭',
                'country_code' => '598',
                'order' => 255,
                'en_name' => 'Uruguay',
            ),
            179 =>
            array(
                'id' => 184,
                'code' => 'UZ',
                'name' => '乌兹别克斯坦',
                'country_code' => '998',
                'order' => 255,
                'en_name' => 'Uzbekistan',
            ),
            180 =>
            array(
                'id' => 185,
                'code' => 'VC',
                'name' => '圣文森特岛',
                'country_code' => '1784',
                'order' => 255,
                'en_name' => 'Saint Vincent',
            ),
            181 =>
            array(
                'id' => 186,
                'code' => 'VE',
                'name' => '委内瑞拉',
                'country_code' => '58',
                'order' => 255,
                'en_name' => 'Venezuela',
            ),
            182 =>
            array(
                'id' => 187,
                'code' => 'VN',
                'name' => '越南',
                'country_code' => '84',
                'order' => 255,
                'en_name' => 'Vietnam',
            ),
            183 =>
            array(
                'id' => 188,
                'code' => 'YE',
                'name' => '也门',
                'country_code' => '967',
                'order' => 255,
                'en_name' => 'Yemen',
            ),
            184 =>
            array(
                'id' => 189,
                'code' => 'YU',
                'name' => '南斯拉夫',
                'country_code' => '381',
                'order' => 255,
                'en_name' => 'Yugoslavia',
            ),
            185 =>
            array(
                'id' => 190,
                'code' => 'ZA',
                'name' => '南非',
                'country_code' => '27',
                'order' => 255,
                'en_name' => 'South Africa',
            ),
            186 =>
            array(
                'id' => 191,
                'code' => 'ZM',
                'name' => '赞比亚',
                'country_code' => '260',
                'order' => 255,
                'en_name' => 'Zambia',
            ),
            187 =>
            array(
                'id' => 192,
                'code' => 'ZR',
                'name' => '扎伊尔',
                'country_code' => '243',
                'order' => 255,
                'en_name' => 'Zaire',
            ),
            188 =>
            array(
                'id' => 193,
                'code' => 'ZW',
                'name' => '津巴布韦',
                'country_code' => '263',
                'order' => 255,
                'en_name' => 'Zimbabwe',
            ),
            189 =>
            array(
                'id' => 194,
                'code' => 'AD',
                'name' => '安道尔共和国',
                'country_code' => '376',
                'order' => 255,
                'en_name' => 'Andorra',
            ),
            190 =>
            array(
                'id' => 195,
                'code' => 'US',
                'name' => '美国',
                'country_code' => '1',
                'order' => 255,
                'en_name' => 'United States',
            ),
        ));
    }
}
