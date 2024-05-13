<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentAdminRolePermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('agent_admin_role_permissions')->delete();

        DB::table('agent_admin_role_permissions')->insert(array(
            0 =>
            array(
                'role_id' => 1,
                'permission_id' => 2,
                'created_at' => '2021-08-05 19:09:11',
                'updated_at' => '2021-08-05 19:09:11',
            ),
            1 =>
            array(
                'role_id' => 1,
                'permission_id' => 3,
                'created_at' => '2021-08-05 19:09:11',
                'updated_at' => '2021-08-05 19:09:11',
            ),
            2 =>
            array(
                'role_id' => 1,
                'permission_id' => 4,
                'created_at' => '2021-08-05 19:09:11',
                'updated_at' => '2021-08-05 19:09:11',
            ),
            3 =>
            array(
                'role_id' => 1,
                'permission_id' => 5,
                'created_at' => '2021-08-05 19:09:11',
                'updated_at' => '2021-08-05 19:09:11',
            ),
            4 =>
            array(
                'role_id' => 1,
                'permission_id' => 6,
                'created_at' => '2021-08-05 19:09:11',
                'updated_at' => '2021-08-05 19:09:11',
            ),
            5 =>
            array(
                'role_id' => 2,
                'permission_id' => 25,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            6 =>
            array(
                'role_id' => 2,
                'permission_id' => 27,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            7 =>
            array(
                'role_id' => 2,
                'permission_id' => 28,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            8 =>
            array(
                'role_id' => 2,
                'permission_id' => 29,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            9 =>
            array(
                'role_id' => 2,
                'permission_id' => 37,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            10 =>
            array(
                'role_id' => 2,
                'permission_id' => 44,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            11 =>
            array(
                'role_id' => 2,
                'permission_id' => 45,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            12 =>
            array(
                'role_id' => 2,
                'permission_id' => 62,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            13 =>
            array(
                'role_id' => 2,
                'permission_id' => 64,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            14 =>
            array(
                'role_id' => 2,
                'permission_id' => 65,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            15 =>
            array(
                'role_id' => 2,
                'permission_id' => 66,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            16 =>
            array(
                'role_id' => 2,
                'permission_id' => 67,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            17 =>
            array(
                'role_id' => 2,
                'permission_id' => 68,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            18 =>
            array(
                'role_id' => 2,
                'permission_id' => 70,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            19 =>
            array(
                'role_id' => 2,
                'permission_id' => 71,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            20 =>
            array(
                'role_id' => 2,
                'permission_id' => 72,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            21 =>
            array(
                'role_id' => 2,
                'permission_id' => 73,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            22 =>
            array(
                'role_id' => 2,
                'permission_id' => 74,
                'created_at' => '2021-08-07 01:17:07',
                'updated_at' => '2021-08-07 01:17:07',
            ),
            23 =>
            array(
                'role_id' => 2,
                'permission_id' => 75,
                'created_at' => '2021-08-07 01:22:30',
                'updated_at' => '2021-08-07 01:22:30',
            ),
            24 =>
            array(
                'role_id' => 3,
                'permission_id' => 25,
                'created_at' => '2021-08-06 11:00:16',
                'updated_at' => '2021-08-06 11:00:16',
            ),
            25 =>
            array(
                'role_id' => 3,
                'permission_id' => 27,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            26 =>
            array(
                'role_id' => 3,
                'permission_id' => 28,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            27 =>
            array(
                'role_id' => 3,
                'permission_id' => 29,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            28 =>
            array(
                'role_id' => 3,
                'permission_id' => 37,
                'created_at' => '2021-08-06 11:00:16',
                'updated_at' => '2021-08-06 11:00:16',
            ),
            29 =>
            array(
                'role_id' => 3,
                'permission_id' => 44,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            30 =>
            array(
                'role_id' => 3,
                'permission_id' => 45,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            31 =>
            array(
                'role_id' => 3,
                'permission_id' => 62,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            32 =>
            array(
                'role_id' => 3,
                'permission_id' => 64,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            33 =>
            array(
                'role_id' => 3,
                'permission_id' => 65,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            34 =>
            array(
                'role_id' => 3,
                'permission_id' => 66,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            35 =>
            array(
                'role_id' => 3,
                'permission_id' => 67,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            36 =>
            array(
                'role_id' => 3,
                'permission_id' => 68,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            37 =>
            array(
                'role_id' => 3,
                'permission_id' => 70,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            38 =>
            array(
                'role_id' => 3,
                'permission_id' => 71,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            39 =>
            array(
                'role_id' => 3,
                'permission_id' => 72,
                'created_at' => '2021-08-06 14:41:44',
                'updated_at' => '2021-08-06 14:41:44',
            ),
            40 =>
            array(
                'role_id' => 3,
                'permission_id' => 73,
                'created_at' => '2021-08-06 16:17:01',
                'updated_at' => '2021-08-06 16:17:01',
            ),
            41 =>
            array(
                'role_id' => 3,
                'permission_id' => 74,
                'created_at' => '2021-08-06 14:42:58',
                'updated_at' => '2021-08-06 14:42:58',
            ),
            42 =>
            array(
                'role_id' => 3,
                'permission_id' => 77,
                'created_at' => '2021-08-16 14:32:29',
                'updated_at' => '2021-08-16 14:32:29',
            ),
        ));
    }
}
