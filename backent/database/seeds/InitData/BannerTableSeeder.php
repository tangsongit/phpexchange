<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('banner')->delete();

        DB::table('banner')->insert(array(
            0 =>
            array(
                'id' => 45,
                'location_type' => 1,
                'tourl' => '#',
                'tourl_type' => 0,
                'status' => 0,
                'order' => 1,
                'created_at' => '2020-09-01 18:05:50',
                'updated_at' => '2020-11-11 17:31:44',
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id' => 46,
                'location_type' => 1,
                'tourl' => '#',
                'tourl_type' => 0,
                'status' => 0,
                'order' => 1,
                'created_at' => '2020-09-01 18:07:07',
                'updated_at' => '2020-11-11 17:31:45',
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id' => 48,
                'location_type' => 1,
                'tourl' => '#',
                'tourl_type' => 0,
                'status' => 0,
                'order' => 1,
                'created_at' => '2020-11-11 17:33:16',
                'updated_at' => '2021-07-16 21:36:44',
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'id' => 49,
                'location_type' => 1,
                'tourl' => '#',
                'tourl_type' => 0,
                'status' => 0,
                'order' => 1,
                'created_at' => '2020-11-11 17:33:52',
                'updated_at' => '2021-05-13 10:49:12',
                'deleted_at' => NULL,
            ),
            4 =>
            array(
                'id' => 50,
                'location_type' => 1,
                'tourl' => '#',
                'tourl_type' => 0,
                'status' => 1,
                'order' => 1,
                'created_at' => '2020-11-11 17:34:29',
                'updated_at' => '2020-11-11 17:34:29',
                'deleted_at' => NULL,
            ),
            5 =>
            array(
                'id' => 51,
                'location_type' => 1,
                'tourl' => '#',
                'tourl_type' => 0,
                'status' => 1,
                'order' => 1,
                'created_at' => '2020-11-11 17:35:23',
                'updated_at' => '2021-07-17 15:41:26',
                'deleted_at' => NULL,
            ),
            6 =>
            array(
                'id' => 52,
                'location_type' => 2,
                'tourl' => '#',
                'tourl_type' => 0,
                'status' => 1,
                'order' => 1,
                'created_at' => '2020-12-18 10:35:30',
                'updated_at' => '2020-12-18 10:35:30',
                'deleted_at' => NULL,
            ),
        ));
    }
}
