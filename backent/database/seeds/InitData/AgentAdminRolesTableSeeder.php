<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentAdminRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('agent_admin_roles')->delete();

        DB::table('agent_admin_roles')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Administrator',
                'slug' => 'administrator',
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => '2020-06-17 18:04:54',
            ),
            1 =>
            array(
                'id' => 2,
                'name' => '代理商',
                'slug' => 'agent',
                'created_at' => '2020-07-23 11:15:32',
                'updated_at' => '2021-08-04 14:44:28',
            ),
            2 =>
            array(
                'id' => 3,
                'name' => '渠道商',
                'slug' => 'place',
                'created_at' => '2021-08-04 16:23:03',
                'updated_at' => '2021-08-04 16:23:03',
            ),
        ));
    }
}
