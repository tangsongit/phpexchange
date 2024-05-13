<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionPairTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('option_pair')->delete();

        DB::table('option_pair')->insert(array(
            0 =>
            array(
                'pair_id' => 1,
                'pair_name' => 'BTC/USDT',
                'symbol' => 'btcusdt',
                'quote_coin_id' => 1,
                'quote_coin_name' => 'USDT',
                'base_coin_id' => 2,
                'base_coin_name' => 'BTC',
                'status' => 1,
                'trade_status' => 1,
                'sort' => 0,
                'created_at' => '2020-06-23 12:08:29',
                'updated_at' => '2020-06-23 12:06:50',
            ),
            1 =>
            array(
                'pair_id' => 2,
                'pair_name' => 'ETH/USDT',
                'symbol' => 'ethusdt',
                'quote_coin_id' => 1,
                'quote_coin_name' => 'USDT',
                'base_coin_id' => 3,
                'base_coin_name' => 'ETH',
                'status' => 1,
                'trade_status' => 1,
                'sort' => 0,
                'created_at' => '2020-06-23 12:08:31',
                'updated_at' => '2020-06-23 12:06:55',
            ),
            2 =>
            array(
                'pair_id' => 3,
                'pair_name' => 'EOS/USDT',
                'symbol' => 'eosusdt',
                'quote_coin_id' => 1,
                'quote_coin_name' => 'USDT',
                'base_coin_id' => 4,
                'base_coin_name' => 'EOS',
                'status' => 1,
                'trade_status' => 1,
                'sort' => 0,
                'created_at' => '2020-06-23 12:08:34',
                'updated_at' => '2020-06-23 12:08:38',
            ),
            3 =>
            array(
                'pair_id' => 4,
                'pair_name' => 'ETC/USDT',
                'symbol' => 'etcusdt',
                'quote_coin_id' => 1,
                'quote_coin_name' => 'USDT',
                'base_coin_id' => 5,
                'base_coin_name' => 'ETC',
                'status' => 1,
                'trade_status' => 1,
                'sort' => 0,
                'created_at' => '2020-06-23 12:08:36',
                'updated_at' => '2020-06-23 12:08:41',
            ),
            4 =>
            array(
                'pair_id' => 5,
                'pair_name' => 'AETC/USDT',
                'symbol' => 'segiusdt',
                'quote_coin_id' => 1,
                'quote_coin_name' => 'USDT',
                'base_coin_id' => 26,
                'base_coin_name' => 'AETC',
                'status' => 0,
                'trade_status' => 0,
                'sort' => 0,
                'created_at' => '2021-04-13 23:43:49',
                'updated_at' => '2021-07-12 13:11:15',
            ),
        ));
    }
}
