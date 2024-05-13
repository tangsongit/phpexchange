<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerTranslationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('banner_translations')->delete();

        DB::table('banner_translations')->insert(array(
            0 =>
            array(
                'id' => 1,
                'b_id' => 40,
                'locale' => 'zh-CN',
                'imgurl' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'b_id' => 40,
                'locale' => 'en',
                'imgurl' => 'https://server.7coin.in/storage/images/d9be355802a7481e60b1d4e8e0d13a2e.png',
            ),
            2 =>
            array(
                'id' => 5,
                'b_id' => 41,
                'locale' => 'zh-CN',
                'imgurl' => 'images/c5ab8863ae3e076c3b4cec91fee33800.png',
            ),
            3 =>
            array(
                'id' => 6,
                'b_id' => 42,
                'locale' => 'zh-CN',
                'imgurl' => 'images/a68a125f822e44120932ec5c009b3c3d.jpg',
            ),
            4 =>
            array(
                'id' => 7,
                'b_id' => 41,
                'locale' => 'en',
                'imgurl' => 'images/6cbde28ffe61007762d8acbddcd28fd0.PNG',
            ),
            5 =>
            array(
                'id' => 8,
                'b_id' => 43,
                'locale' => 'zh-CN',
                'imgurl' => 'images/f5c545af5ed96cdf4d1e1431bebca47c.png',
            ),
            6 =>
            array(
                'id' => 9,
                'b_id' => 43,
                'locale' => 'en',
                'imgurl' => 'images/2982e9106741741c784dec1c347920b7.png',
            ),
            7 =>
            array(
                'id' => 10,
                'b_id' => 43,
                'locale' => 'zh-TW',
                'imgurl' => 'images/8cfe79f70a112dc39ea00cc2e606d5f4.png',
            ),
            8 =>
            array(
                'id' => 11,
                'b_id' => 44,
                'locale' => 'zh-CN',
                'imgurl' => 'images/ac2d2aae25407c558ee352b1f9a4b0b7.png',
            ),
            9 =>
            array(
                'id' => 12,
                'b_id' => 44,
                'locale' => 'en',
                'imgurl' => 'images/0b5782a1eedd580c504dfb57067b3ab2.png',
            ),
            10 =>
            array(
                'id' => 13,
                'b_id' => 44,
                'locale' => 'zh-TW',
                'imgurl' => 'images/1e922c6f16a7c50ebf25c43b2c32d716.png',
            ),
            11 =>
            array(
                'id' => 14,
                'b_id' => 45,
                'locale' => 'zh-CN',
                'imgurl' => 'images/14885702cf3776a69a0474b14453e58d.jpg',
            ),
            12 =>
            array(
                'id' => 15,
                'b_id' => 45,
                'locale' => 'en',
                'imgurl' => 'images/63db8b581dcedcb83d9d4b63ce306cb2.jpg',
            ),
            13 =>
            array(
                'id' => 16,
                'b_id' => 45,
                'locale' => 'zh-TW',
                'imgurl' => 'images/5a58fe67bdd961819737884a05e24184.jpg',
            ),
            14 =>
            array(
                'id' => 17,
                'b_id' => 46,
                'locale' => 'zh-CN',
                'imgurl' => 'images/45d8b33104d2eb1164f4a336adc3f8ce.png',
            ),
            15 =>
            array(
                'id' => 18,
                'b_id' => 46,
                'locale' => 'en',
                'imgurl' => 'images/cc630eec8274d6aae167451c1b2d7402.png',
            ),
            16 =>
            array(
                'id' => 19,
                'b_id' => 46,
                'locale' => 'zh-TW',
                'imgurl' => 'images/ed431141ac8c0857d4dfcd55460c7c84.png',
            ),
            17 =>
            array(
                'id' => 20,
                'b_id' => 47,
                'locale' => 'zh-CN',
                'imgurl' => 'images/12ba62d444c5adef9869f6d330f30422.png',
            ),
            18 =>
            array(
                'id' => 21,
                'b_id' => 47,
                'locale' => 'en',
                'imgurl' => 'images/ea37385e151eaf0069c758e578f62249.png',
            ),
            19 =>
            array(
                'id' => 22,
                'b_id' => 47,
                'locale' => 'zh-TW',
                'imgurl' => 'images/d19da19df8d7d883d483db2ac0df0dae.png',
            ),
            20 =>
            array(
                'id' => 23,
                'b_id' => 48,
                'locale' => 'zh-CN',
                'imgurl' => 'images/b9bf742ef2a20ba224150737c1991b34.png',
            ),
            21 =>
            array(
                'id' => 24,
                'b_id' => 48,
                'locale' => 'en',
                'imgurl' => 'images/b42880e86a202496b5c775e533079c8f.png',
            ),
            22 =>
            array(
                'id' => 25,
                'b_id' => 48,
                'locale' => 'zh-TW',
                'imgurl' => 'images/7ea2e20b9895092831eae4326b8c4e8a.png',
            ),
            23 =>
            array(
                'id' => 26,
                'b_id' => 49,
                'locale' => 'zh-CN',
                'imgurl' => NULL,
            ),
            24 =>
            array(
                'id' => 27,
                'b_id' => 49,
                'locale' => 'en',
                'imgurl' => 'images/0838da314315da20e121f7109b46e807.jpg',
            ),
            25 =>
            array(
                'id' => 28,
                'b_id' => 49,
                'locale' => 'zh-TW',
                'imgurl' => 'images/57148a189a0f9a4daa77a5481e9ff9d3.jpg',
            ),
            26 =>
            array(
                'id' => 29,
                'b_id' => 50,
                'locale' => 'zh-CN',
                'imgurl' => 'images/38350088e0f509a0b706a5d7d7a9656d.png',
            ),
            27 =>
            array(
                'id' => 30,
                'b_id' => 50,
                'locale' => 'en',
                'imgurl' => 'images/5cffec31425fd4db745644157fdece1c.png',
            ),
            28 =>
            array(
                'id' => 31,
                'b_id' => 50,
                'locale' => 'zh-TW',
                'imgurl' => 'images/883c41815567bf84819878ea80edfdcc.png',
            ),
            29 =>
            array(
                'id' => 32,
                'b_id' => 51,
                'locale' => 'zh-CN',
                'imgurl' => 'images/87e6f0453a8fe3890c57d674aa647632.jpg',
            ),
            30 =>
            array(
                'id' => 33,
                'b_id' => 51,
                'locale' => 'en',
                'imgurl' => 'images/5a7dadfc2d2afcd084628385a802c99f.jpg',
            ),
            31 =>
            array(
                'id' => 34,
                'b_id' => 51,
                'locale' => 'zh-TW',
                'imgurl' => 'images/cfe87f0d68539b7a679842b3c0166574.jpg',
            ),
            32 =>
            array(
                'id' => 35,
                'b_id' => 52,
                'locale' => 'zh-CN',
                'imgurl' => 'images/ece159afeb0539d5a614533cf147161a.jpg',
            ),
            33 =>
            array(
                'id' => 36,
                'b_id' => 52,
                'locale' => 'en',
                'imgurl' => 'images/5ed2b364f72360a99f5a551f715de251.jpg',
            ),
            34 =>
            array(
                'id' => 37,
                'b_id' => 52,
                'locale' => 'zh-TW',
                'imgurl' => 'images/e0ee5dbc7a9a8779f0f304037e0b9544.jpg',
            ),
            35 =>
            array(
                'id' => 38,
                'b_id' => 53,
                'locale' => 'zh-CN',
                'imgurl' => 'images/ed465e9f88d7df93bcb8d06bc8bd6413.jpg',
            ),
            36 =>
            array(
                'id' => 39,
                'b_id' => 52,
                'locale' => 'kor',
                'imgurl' => 'images/aa73c2ea75f84b5fb80ff4d55b5714d9.jpg',
            ),
            37 =>
            array(
                'id' => 40,
                'b_id' => 52,
                'locale' => 'jp',
                'imgurl' => 'images/c7329569c23a6ff58e40ee61663f6dbc.jpg',
            ),
            38 =>
            array(
                'id' => 45,
                'b_id' => 49,
                'locale' => 'kor',
                'imgurl' => 'images/340dc3950fa768049e88fd20a9fab58f.jpg',
            ),
            39 =>
            array(
                'id' => 46,
                'b_id' => 49,
                'locale' => 'jp',
                'imgurl' => 'images/3fd32c70325331677e495fe2c523fa16.jpg',
            ),
            40 =>
            array(
                'id' => 47,
                'b_id' => 51,
                'locale' => 'kor',
                'imgurl' => 'images/0f24846a576f151e5a12136e4d4c110c.jpg',
            ),
            41 =>
            array(
                'id' => 48,
                'b_id' => 51,
                'locale' => 'jp',
                'imgurl' => 'images/87c4d749c85910e060dffbfd63a4c822.jpg',
            ),
            42 =>
            array(
                'id' => 49,
                'b_id' => 50,
                'locale' => 'kor',
                'imgurl' => 'images/0a878758af7466245c45a1a26b9934d1.png',
            ),
            43 =>
            array(
                'id' => 50,
                'b_id' => 50,
                'locale' => 'jp',
                'imgurl' => 'images/b36579f51c3d1b615b7275e6fa6f3ab9.png',
            ),
            44 =>
            array(
                'id' => 53,
                'b_id' => 48,
                'locale' => 'kor',
                'imgurl' => 'images/da8cc551dbe0b82a712cf6a95e4603eb.png',
            ),
            45 =>
            array(
                'id' => 54,
                'b_id' => 48,
                'locale' => 'jp',
                'imgurl' => 'images/2078b791b07286068b4b1e3b423c867e.png',
            ),
            46 =>
            array(
                'id' => 55,
                'b_id' => 48,
                'locale' => 'de',
                'imgurl' => 'images/3d409bbc639928e92d0db724cb87f94c.png',
            ),
            47 =>
            array(
                'id' => 56,
                'b_id' => 48,
                'locale' => 'it',
                'imgurl' => 'images/fe1926fc93b1811971328d880d5837e2.png',
            ),
            48 =>
            array(
                'id' => 57,
                'b_id' => 48,
                'locale' => 'nl',
                'imgurl' => 'images/2ac21c83be267319b174fb7f002d2618.png',
            ),
            49 =>
            array(
                'id' => 58,
                'b_id' => 48,
                'locale' => 'pl',
                'imgurl' => 'images/8b5d87c3203f493ae133a89136c237b7.png',
            ),
            50 =>
            array(
                'id' => 59,
                'b_id' => 48,
                'locale' => 'pt',
                'imgurl' => 'images/4359c95f2e965e26627e6cd93f4e3e42.png',
            ),
            51 =>
            array(
                'id' => 60,
                'b_id' => 48,
                'locale' => 'spa',
                'imgurl' => 'images/12661ac3bd8a3194b378723dc15d11d0.png',
            ),
            52 =>
            array(
                'id' => 61,
                'b_id' => 48,
                'locale' => 'spa',
                'imgurl' => 'images/e5525ac3de23dc33b862555d3b5db620.png',
            ),
            53 =>
            array(
                'id' => 62,
                'b_id' => 48,
                'locale' => 'swe',
                'imgurl' => 'images/97aa1ba68b374a32200e95fcd443c88c.png',
            ),
            54 =>
            array(
                'id' => 63,
                'b_id' => 48,
                'locale' => 'tr',
                'imgurl' => 'images/f9d5e673eae216d90f88b434c5dcabb4.png',
            ),
            55 =>
            array(
                'id' => 64,
                'b_id' => 48,
                'locale' => 'uk',
                'imgurl' => 'images/f96a3b71e0add4d04b79094837de30d2.png',
            ),
            56 =>
            array(
                'id' => 65,
                'b_id' => 50,
                'locale' => 'de',
                'imgurl' => 'images/09e30554ad8b806b0264c302bfca228f.png',
            ),
            57 =>
            array(
                'id' => 66,
                'b_id' => 50,
                'locale' => 'it',
                'imgurl' => 'images/7e39be5d6ee4977bb86387dd4f128262.png',
            ),
            58 =>
            array(
                'id' => 67,
                'b_id' => 50,
                'locale' => 'nl',
                'imgurl' => 'images/43fa8ff03fc4a196b960bdf41fc5cd8c.png',
            ),
            59 =>
            array(
                'id' => 68,
                'b_id' => 50,
                'locale' => 'nl',
                'imgurl' => 'images/9fff2062e621f8c9fe3a86d1f4615c38.png',
            ),
            60 =>
            array(
                'id' => 69,
                'b_id' => 50,
                'locale' => 'pl',
                'imgurl' => 'images/a8f272dd398c762fb84e701f197444bb.png',
            ),
            61 =>
            array(
                'id' => 70,
                'b_id' => 50,
                'locale' => 'pt',
                'imgurl' => 'images/b95e5c4a5eb6000db70cfc585def8cf7.png',
            ),
            62 =>
            array(
                'id' => 71,
                'b_id' => 50,
                'locale' => 'spa',
                'imgurl' => 'images/2d6dd1b72f3515e475ddf5955c04eb97.png',
            ),
            63 =>
            array(
                'id' => 72,
                'b_id' => 50,
                'locale' => 'swe',
                'imgurl' => 'images/1d3217ea4eaf198624b7a5bdeccddc22.png',
            ),
            64 =>
            array(
                'id' => 73,
                'b_id' => 50,
                'locale' => 'tr',
                'imgurl' => 'images/4310bcb6d236a2734697b6308f0667af.png',
            ),
            65 =>
            array(
                'id' => 74,
                'b_id' => 50,
                'locale' => 'uk',
                'imgurl' => 'images/975a88d945b2697223d8e5a8d904f8a8.png',
            ),
            66 =>
            array(
                'id' => 75,
                'b_id' => 51,
                'locale' => 'de',
                'imgurl' => 'images/1b84ec322ce8cfe451b1b669278152af.jpg',
            ),
            67 =>
            array(
                'id' => 76,
                'b_id' => 51,
                'locale' => 'it',
                'imgurl' => 'images/9a04e313cd1298256c151ec249074217.jpg',
            ),
            68 =>
            array(
                'id' => 77,
                'b_id' => 51,
                'locale' => 'nl',
                'imgurl' => 'images/124064d34f3379ddd8491f931af80a1b.jpg',
            ),
            69 =>
            array(
                'id' => 78,
                'b_id' => 51,
                'locale' => 'pl',
                'imgurl' => 'images/204ec998399bf59aa9300893dcbf30ab.jpg',
            ),
            70 =>
            array(
                'id' => 79,
                'b_id' => 51,
                'locale' => 'pt',
                'imgurl' => 'images/d83e9bb156244ab6a095682037545fa8.jpg',
            ),
            71 =>
            array(
                'id' => 80,
                'b_id' => 51,
                'locale' => 'spa',
                'imgurl' => 'images/5ad575561b6238f14b315700883a6733.jpg',
            ),
            72 =>
            array(
                'id' => 81,
                'b_id' => 51,
                'locale' => 'swe',
                'imgurl' => 'images/b000f708c4aa0d3c4ba1448f90cca63a.jpg',
            ),
            73 =>
            array(
                'id' => 82,
                'b_id' => 51,
                'locale' => 'tr',
                'imgurl' => 'images/d387aaea72c16a1b45d1a200f065da04.jpg',
            ),
            74 =>
            array(
                'id' => 83,
                'b_id' => 51,
                'locale' => 'uk',
                'imgurl' => 'images/dd1541e21428959ceb61300b49b4c6ce.jpg',
            ),
            75 =>
            array(
                'id' => 84,
                'b_id' => 52,
                'locale' => 'de',
                'imgurl' => 'images/603a36ef504e15017f01df7b68f81ef2.jpg',
            ),
            76 =>
            array(
                'id' => 85,
                'b_id' => 52,
                'locale' => 'it',
                'imgurl' => 'images/a857ff81013bdb089eeb3d53e53637e6.jpg',
            ),
            77 =>
            array(
                'id' => 86,
                'b_id' => 52,
                'locale' => 'nl',
                'imgurl' => 'images/458388f3bfae12d6f47a7e3700ac6198.jpg',
            ),
            78 =>
            array(
                'id' => 87,
                'b_id' => 52,
                'locale' => 'pl',
                'imgurl' => 'images/5115d8a03fc553adc14e0c3ff370ebb6.jpg',
            ),
            79 =>
            array(
                'id' => 88,
                'b_id' => 52,
                'locale' => 'pt',
                'imgurl' => 'images/845b565e056936bfa313c820d29305bd.jpg',
            ),
            80 =>
            array(
                'id' => 89,
                'b_id' => 52,
                'locale' => 'pt',
                'imgurl' => 'images/c73ae76338790b65a3d266162a5bdff0.jpg',
            ),
            81 =>
            array(
                'id' => 90,
                'b_id' => 52,
                'locale' => 'spa',
                'imgurl' => 'images/fe30a50b08e710164620d018d3f3463a.jpg',
            ),
            82 =>
            array(
                'id' => 91,
                'b_id' => 52,
                'locale' => 'swe',
                'imgurl' => 'images/d529e8d5683201a72f880f00720d117b.jpg',
            ),
            83 =>
            array(
                'id' => 92,
                'b_id' => 52,
                'locale' => 'tr',
                'imgurl' => 'images/fc3376c3f62dbdf628906c91d8212825.jpg',
            ),
            84 =>
            array(
                'id' => 93,
                'b_id' => 52,
                'locale' => 'uk',
                'imgurl' => 'images/edc7ca5a90920952fff8048643ae5257.jpg',
            ),
        ));
    }
}
