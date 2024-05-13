<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('admin_users')->delete();

        DB::table('admin_users')->insert(array(
            0 =>
            array(
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$nmO29RSc5dyEWdl2/AIPKOGL3dX7xBeljSRO9zGpMT5VIQPtsrHdW',
                'name' => 'Administrator',
                'avatar' => NULL,
                'remember_token' => 'a1REkTgj9KGSsvn02Z5UZg6nySQ1bxjTUVe93MujSswdGZ1Up4qIvm9sUqiA',
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => '2021-08-06 20:37:41',
            ),
        ));
    }
}
