<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppVersionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('app_version')->delete();

        DB::table('app_version')->insert(array(
            0 =>
            array(
                'id' => 1,
                'client_type' => 1,
                'version' => '1.0.0',
                'is_must' => 1,
                'update_log' => NULL,
                'url' => 'https://www.pcicoin.com/download/android/PCI.apk',
                'created_at' => '2019-07-17 11:43:55',
                'updated_at' => '2021-07-13 19:16:23',
            ),
            1 =>
            array(
                'id' => 2,
                'client_type' => 2,
                'version' => '1.0.0',
                'is_must' => 1,
                'update_log' => NULL,
                'url' => 'https://gjltf.com/app/PCI',
                'created_at' => '2019-07-15 16:40:02',
                'updated_at' => '2021-07-13 19:11:22',
            ),
        ));
    }
}
