<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OtcCoinlistTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('otc_coinlist')->delete();

        DB::table('otc_coinlist')->insert(array(
            0 =>
            array(
                'id' => 1,
                'coin_id' => 1,
                'coin_name' => 'USDT',
                'limit_amount' => '1000.0000',
                'max_register_time' => '72',
                'max_register_num' => '1',
                'status' => 1,
                'created_at' => '2021-03-23 15:37:56',
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'coin_id' => 2,
                'coin_name' => 'BTC',
                'limit_amount' => '0.1000',
                'max_register_time' => '72',
                'max_register_num' => '1',
                'status' => 1,
                'created_at' => '2021-03-23 15:37:58',
                'updated_at' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'coin_id' => 3,
                'coin_name' => 'ETH',
                'limit_amount' => '1.0000',
                'max_register_time' => '72',
                'max_register_num' => '1',
                'status' => 1,
                'created_at' => '2021-03-23 15:38:01',
                'updated_at' => NULL,
            ),
        ));
    }
}
