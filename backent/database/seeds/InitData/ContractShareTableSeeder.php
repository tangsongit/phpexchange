<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractShareTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('contract_share')->delete();

        DB::table('contract_share')->insert(array(
            0 =>
            array(
                'id' => 1,
                'bg_img' => 'images/ffeccb8644eb0f4cada671343b3168eb.png',
                'text_img' => 'images/ff5d4030e8be2374b8fdee55b5085005.png',
                'peri_img' => 'images/ee7b39cf07be7934cb6a87b962cdf654.png',
                'status' => 0,
                'created_at' => 1605267532,
                'updated_at' => 1628254450,
            ),
            1 =>
            array(
                'id' => 2,
                'bg_img' => 'images/8f985dfe33a0eb7f677caee1379eb90a.png',
                'text_img' => 'images/ddb6b5efe9306acbdac51f71a637efb1.png',
                'peri_img' => 'images/a7887f2ff0cd53edf2542d7aa5ace12b.png',
                'status' => 0,
                'created_at' => 1605267615,
                'updated_at' => 1628254451,
            ),
            2 =>
            array(
                'id' => 3,
                'bg_img' => 'images/04cce3b2354fb1f1654efbf0293b0102.png',
                'text_img' => 'images/70d4faa8d615815933d61036da116fbc.png',
                'peri_img' => 'images/ecc259c583fe297300b125f4e7e51067.png',
                'status' => 0,
                'created_at' => 1605268216,
                'updated_at' => 1628254452,
            ),
            3 =>
            array(
                'id' => 4,
                'bg_img' => 'images/7963dbf14031976d1dd7fc2aa88606de.png',
                'text_img' => 'images/39bbd9cf9f7d823079fbe5e78066c02c.png',
                'peri_img' => 'images/994ec0dcfa6c3b042dbf58039d5ea6fa.png',
                'status' => 1,
                'created_at' => 1605267475,
                'updated_at' => 1605267636,
            ),
            4 =>
            array(
                'id' => 5,
                'bg_img' => 'images/70ed59d8408b968d19db1a7d6099d5d0.png',
                'text_img' => 'images/eda9c1644b359dda06af537a14643fae.png',
                'peri_img' => 'images/5ea62d23cb7b6315c100377e09b3a9f8.png',
                'status' => 1,
                'created_at' => 1605267501,
                'updated_at' => 1605267501,
            ),
            5 =>
            array(
                'id' => 6,
                'bg_img' => 'images/29f9fd786667e3e37ce5be26fef74b91.png',
                'text_img' => 'images/e0f782fe33903a69a0e77aa2b30a4334.png',
                'peri_img' => 'images/937ba4ed9e52e3331b941432ecbed3b8.png',
                'status' => 1,
                'created_at' => 1605267667,
                'updated_at' => 1605267667,
            ),
        ));
    }
}
