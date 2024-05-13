<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TranslateTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('translate')->delete();

        DB::table('translate')->insert(array(
            0 =>
            array(
                'id' => 1,
                'lang' => 'en',
                'json_content' => '"{\\"key1\\":\\"value1\\"}"',
                'file' => 'files/country.json',
                'created_at' => '2020-07-29 10:39:59',
                'updated_at' => '2020-07-29 11:12:43',
            ),
            1 =>
            array(
                'id' => 2,
                'lang' => 'zh-CN',
                'json_content' => '{"key1": "値1"}',
                'file' => 'files/country.json',
                'created_at' => '2020-07-29 10:40:00',
                'updated_at' => '2020-07-29 11:08:41',
            ),
            2 =>
            array(
                'id' => 3,
                'lang' => 'zh-TW',
                'json_content' => '{"key1": "値1"}',
                'file' => 'files/country.json',
                'created_at' => '2020-07-29 10:40:03',
                'updated_at' => '2020-07-29 10:56:41',
            ),
            3 =>
            array(
                'id' => 4,
                'lang' => 'jp',
                'json_content' => '{"key1": "値1"}',
                'file' => 'files/country.json',
                'created_at' => '2020-07-29 10:40:03',
                'updated_at' => '2020-07-29 10:56:41',
            ),
        ));
    }
}
