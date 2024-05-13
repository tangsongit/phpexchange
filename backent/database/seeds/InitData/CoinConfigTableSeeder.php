<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoinConfigTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('coin_config')->delete();

        DB::table('coin_config')->insert(array(
            0 =>
            array(
                'id' => 1,
                'symbol' => 'TKB',
                'datetime' => '2021-07-21 00:00:00',
                'name' => '',
                'open' => NULL,
                'high' => NULL,
                'low' => NULL,
                'close' => NULL,
                'min_amount' => 1000.0,
                'max_amount' => 10000.0,
                'status' => 0,
                'created_at' => '2021-07-21 23:53:23',
                'updated_at' => '2021-07-21 23:53:23',
            ),
            1 =>
            array(
                'id' => 2,
                'symbol' => 'TKB',
                'datetime' => '2021-07-22 00:00:00',
                'name' => '',
                'open' => NULL,
                'high' => NULL,
                'low' => NULL,
                'close' => NULL,
                'min_amount' => 1000.0,
                'max_amount' => 10000.0,
                'status' => 0,
                'created_at' => '2021-07-21 23:55:44',
                'updated_at' => '2021-07-21 23:55:44',
            ),
            2 =>
            array(
                'id' => 3,
                'symbol' => 'TKB',
                'datetime' => '2021-07-23 00:00:00',
                'name' => '',
                'open' => NULL,
                'high' => NULL,
                'low' => NULL,
                'close' => NULL,
                'min_amount' => 1000.0,
                'max_amount' => 10000.0,
                'status' => 0,
                'created_at' => '2021-07-22 23:40:45',
                'updated_at' => '2021-07-22 23:40:45',
            ),
            3 =>
            array(
                'id' => 4,
                'symbol' => 'TKB',
                'datetime' => '2021-07-24 00:00:00',
                'name' => '',
                'open' => NULL,
                'high' => NULL,
                'low' => NULL,
                'close' => NULL,
                'min_amount' => 1000.0,
                'max_amount' => 10000.0,
                'status' => 0,
                'created_at' => '2021-07-24 16:15:45',
                'updated_at' => '2021-07-24 16:15:45',
            ),
            4 =>
            array(
                'id' => 5,
                'symbol' => 'GITP',
                'datetime' => '2021-07-24 00:00:00',
                'name' => '',
                'open' => NULL,
                'high' => NULL,
                'low' => NULL,
                'close' => NULL,
                'min_amount' => 1000.0,
                'max_amount' => 10000.0,
                'status' => 0,
                'created_at' => '2021-07-24 16:15:47',
                'updated_at' => '2021-07-24 16:15:47',
            ),
        ));
    }
}
