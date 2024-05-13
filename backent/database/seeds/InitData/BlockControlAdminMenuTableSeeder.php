<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlockControlAdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('block_control_admin_menu')->delete();

        DB::table('block_control_admin_menu')->insert(array(
            0 =>
            array(
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Index',
                'icon' => 'feather icon-bar-chart-2',
                'uri' => '/',
                'created_at' => '2020-07-27 11:28:50',
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'parent_id' => 0,
                'order' => 2,
                'title' => 'Admin',
                'icon' => 'feather icon-settings',
                'uri' => '',
                'created_at' => '2020-07-27 11:28:50',
                'updated_at' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'parent_id' => 2,
                'order' => 3,
                'title' => 'Users',
                'icon' => '',
                'uri' => 'auth/users',
                'created_at' => '2020-07-27 11:28:50',
                'updated_at' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'parent_id' => 2,
                'order' => 4,
                'title' => 'Roles',
                'icon' => '',
                'uri' => 'auth/roles',
                'created_at' => '2020-07-27 11:28:50',
                'updated_at' => NULL,
            ),
            4 =>
            array(
                'id' => 5,
                'parent_id' => 2,
                'order' => 5,
                'title' => 'Permission',
                'icon' => '',
                'uri' => 'auth/permissions',
                'created_at' => '2020-07-27 11:28:50',
                'updated_at' => NULL,
            ),
            5 =>
            array(
                'id' => 6,
                'parent_id' => 2,
                'order' => 6,
                'title' => 'Menu',
                'icon' => '',
                'uri' => 'auth/menu',
                'created_at' => '2020-07-27 11:28:50',
                'updated_at' => NULL,
            ),
            6 =>
            array(
                'id' => 7,
                'parent_id' => 2,
                'order' => 7,
                'title' => 'Operation log',
                'icon' => '',
                'uri' => 'auth/logs',
                'created_at' => '2020-07-27 11:28:50',
                'updated_at' => NULL,
            ),
            7 =>
            array(
                'id' => 14,
                'parent_id' => 0,
                'order' => 12,
                'title' => '风控管理',
                'icon' => 'fa-cc-jcb',
                'uri' => NULL,
                'created_at' => '2020-09-28 10:56:19',
                'updated_at' => '2021-07-12 14:28:57',
            ),
            8 =>
            array(
                'id' => 16,
                'parent_id' => 14,
                'order' => 13,
                'title' => '合约风控',
                'icon' => NULL,
                'uri' => 'contract-risk',
                'created_at' => '2020-10-10 09:59:17',
                'updated_at' => '2020-10-10 09:59:37',
            ),
            9 =>
            array(
                'id' => 17,
                'parent_id' => 14,
                'order' => 14,
                'title' => '行情控制',
                'icon' => NULL,
                'uri' => 'kline-robot',
                'created_at' => '2021-07-12 14:29:26',
                'updated_at' => '2021-07-12 14:29:26',
            ),
        ));
    }
}
