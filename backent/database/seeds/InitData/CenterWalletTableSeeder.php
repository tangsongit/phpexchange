<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CenterWalletTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('center_wallet')->delete();

        DB::table('center_wallet')->insert(array(
            0 =>
            array(
                'center_wallet_id' => 1,
                'center_wallet_name' => 'ETH手续费账户',
                'center_wallet_account' => 'eth_fee_account',
                'center_wallet_address' => '',
                'center_wallet_password' => '',
                'center_wallet_balance' => '0.000000000000',
                'coin_id' => 3,
                'min_amount' => NULL,
                'created_at' => '2018-08-15 10:00:00',
                'updated_at' => '2018-08-15 10:00:00',
            ),
            1 =>
            array(
                'center_wallet_id' => 2,
                'center_wallet_name' => 'ETH归集账户',
                'center_wallet_account' => 'eth_collection_account',
                'center_wallet_address' => '',
                'center_wallet_password' => '',
                'center_wallet_balance' => '0.000000000000',
                'coin_id' => 3,
                'min_amount' => NULL,
                'created_at' => '2020-09-12 17:28:04',
                'updated_at' => '2020-09-12 17:28:06',
            ),
            2 =>
            array(
                'center_wallet_id' => 3,
                'center_wallet_name' => 'BTC手续费账户',
                'center_wallet_account' => 'btc_fee_account',
                'center_wallet_address' => '',
                'center_wallet_password' => '',
                'center_wallet_balance' => '0.000000000000',
                'coin_id' => 2,
                'min_amount' => NULL,
                'created_at' => '2020-09-17 10:02:10',
                'updated_at' => '2020-09-17 10:02:13',
            ),
            3 =>
            array(
                'center_wallet_id' => 4,
                'center_wallet_name' => 'BTC归集账户',
                'center_wallet_account' => 'btc_collection_account',
                'center_wallet_address' => '',
                'center_wallet_password' => '',
                'center_wallet_balance' => '0.000000000000',
                'coin_id' => 2,
                'min_amount' => NULL,
                'created_at' => '2020-09-17 10:02:39',
                'updated_at' => '2020-09-17 10:02:41',
            ),
        ));
    }
}
