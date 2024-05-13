<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-09 18:30:22
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 18:49:37
 */

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionBetCoinTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('option_bet_coin')->delete();

        DB::table('option_bet_coin')->insert(array(
            0 =>
            array(
                'id' => 1,
                'coin_id' => 1,
                'coin_name' => 'USDT',
                'min_amount' => '1',
                'max_amount' => '1000',
                'is_bet'    => '1',
                'sort'      => '1',
                'created_at' => '2020-07-16 10:54:20',
                'updated_at' => NULL

            ),
            1 =>
            array(
                'id' => 2,
                'coin_id' => 2,
                'coin_name' => 'BTC',
                'min_amount' => '0.0001',
                'max_amount' => '0.7',
                'is_bet'    => '0',
                'sort'      => '1',
                'created_at' => '2020-07-16 10:54:23',
                'updated_at' => NULL

            ),
            2 =>
            array(
                'id' => 3,
                'coin_id' => 3,
                'coin_name' => 'ETH',
                'min_amount' => '0.01',
                'max_amount' => '25',
                'is_bet'    => '0',
                'sort'      => '1',
                'created_at' => '2020-07-16 10:54:25',
                'updated_at' => NULL

            ),
        ));
    }
}
