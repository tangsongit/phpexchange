<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRoleMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('admin_role_menu')->delete();

        DB::table('admin_role_menu')->insert(array(
            0 =>
            array(
                'role_id' => 1,
                'menu_id' => 23,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'role_id' => 1,
                'menu_id' => 24,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array(
                'role_id' => 3,
                'menu_id' => 12,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
    }
}
