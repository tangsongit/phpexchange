<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionTimeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('option_time')->delete();

        DB::table('option_time')->insert(array(
            0 =>
            array(
                'time_id' => 1,
                'time_name' => '1M',
                'seconds' => 60,
                'fee_rate' => '0.0000',
                'odds_up_range' => '[{"odds": "1.8", "range": "0.03", "is_default": 1}, {"odds": "1.8", "range": "3.5"}, {"odds": "1.8", "range": "6.3"}, {"odds": "1.8", "range": "8.7"}, {"odds": "1.8", "range": "10.5"}]',
                'odds_down_range' => '[{"odds": "1.8", "range": "0.03", "is_default": 1}, {"odds": "1.8", "range": "3.5"}, {"odds": "1.8", "range": "6.3"}, {"odds": "1.8", "range": "8.7"}, {"odds": "1.8", "range": "10.5"}]',
                'odds_draw_range' => '[{"odds": "1.8", "range": "0.03", "is_default": 1}]',
                'status' => 1,
                'created_at' => '2020-06-20 11:19:51',
                'updated_at' => '2021-08-04 17:18:36',
            ),
            1 =>
            array(
                'time_id' => 2,
                'time_name' => '15M',
                'seconds' => 900,
                'fee_rate' => '0.0000',
                'odds_up_range' => '[{"odds": "1.8", "range": "0.04", "is_default": 1}, {"odds": "1.8", "range": "3.5"}, {"odds": "1.8", "range": "6.3"}, {"odds": "1.8", "range": "8.7"}, {"odds": "1.8", "range": "10.6"}]',
                'odds_down_range' => '[{"odds": "1.8", "range": "0.04", "is_default": 1}, {"odds": "1.8", "range": "3.5"}, {"odds": "1.8", "range": "6.3"}, {"odds": "1.8", "range": "8.7"}, {"odds": "1.8", "range": "10.6"}]',
                'odds_draw_range' => '[{"odds": "1.8", "range": "0.04", "is_default": 1}]',
                'status' => 1,
                'created_at' => '2020-06-20 11:19:53',
                'updated_at' => '2020-08-20 16:30:03',
            ),
            2 =>
            array(
                'time_id' => 3,
                'time_name' => '30M',
                'seconds' => 1800,
                'fee_rate' => '0.0000',
                'odds_up_range' => '[{"odds": "1.8", "range": "0.05", "is_default": 1}, {"odds": "1.8", "range": "3.5"}, {"odds": "1.8", "range": "6.3"}, {"odds": "1.8", "range": "8.7"}, {"odds": "1.8", "range": "10.7"}]',
                'odds_down_range' => '[{"odds": "1.8", "range": "0.05", "is_default": 1}, {"odds": "1.8", "range": "3.5"}, {"odds": "1.8", "range": "6.3"}, {"odds": "1.8", "range": "8.7"}, {"odds": "1.8", "range": "10.7"}]',
                'odds_draw_range' => '[{"odds": "1.8", "range": "0.05", "is_default": 1}]',
                'status' => 1,
                'created_at' => '2020-06-20 11:19:55',
                'updated_at' => '2020-08-20 16:30:08',
            ),
            3 =>
            array(
                'time_id' => 4,
                'time_name' => '1H',
                'seconds' => 3600,
                'fee_rate' => '0.0000',
                'odds_up_range' => '[{"odds": "1.8", "range": "0.06", "is_default": 1}, {"odds": "1.8", "range": "3.5"}, {"odds": "1.8", "range": "6.3"}, {"odds": "1.8", "range": "8.7"}, {"odds": "1.8", "range": "10.8"}]',
                'odds_down_range' => '[{"odds": "1.8", "range": "0.06", "is_default": 1}, {"odds": "1.8", "range": "3.5"}, {"odds": "1.8", "range": "6.3"}, {"odds": "1.8", "range": "8.7"}, {"odds": "1.8", "range": "10.8"}]',
                'odds_draw_range' => '[{"odds": "1.8", "range": "0.06", "is_default": 1}]',
                'status' => 1,
                'created_at' => '2020-06-20 11:19:58',
                'updated_at' => '2020-08-20 16:30:13',
            ),
            4 =>
            array(
                'time_id' => 5,
                'time_name' => '1D',
                'seconds' => 86400,
                'fee_rate' => '0.0000',
                'odds_up_range' => '[{"odds": "1.8", "range": "0.07", "is_default": 1}, {"odds": "1.8", "range": "3.5"}, {"odds": "1.8", "range": "6.3"}, {"odds": "1.8", "range": "8.7"}, {"odds": "1.8", "range": "10.9"}]',
                'odds_down_range' => '[{"odds": "1.8", "range": "0.07", "is_default": 1}, {"odds": "1.8", "range": "3.5"}, {"odds": "1.8", "range": "6.3"}, {"odds": "1.8", "range": "8.7"}, {"odds": "1.8", "range": "10.9"}]',
                'odds_draw_range' => '[{"odds": "1.8", "range": "0.07", "is_default": 1}]',
                'status' => 0,
                'created_at' => '2020-06-20 11:20:00',
                'updated_at' => '2021-01-20 19:38:01',
            ),
        ));
    }
}
