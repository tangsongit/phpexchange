<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('admin_roles')->delete();

        DB::table('admin_roles')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => '超级管理员',
                'slug' => 'administrator',
                'created_at' => '2020-06-17 18:04:54',
                'updated_at' => '2021-08-06 20:43:31',
            ),
            1 =>
            array(
                'id' => 3,
                'name' => '客服',
                'slug' => '客服',
                'created_at' => '2020-09-02 16:33:30',
                'updated_at' => '2021-05-12 15:19:14',
            ),
            2 =>
            array(
                'id' => 4,
                'name' => '财务',
                'slug' => '财务',
                'created_at' => '2020-09-15 13:58:41',
                'updated_at' => '2021-05-12 15:19:22',
            ),
            3 =>
            array(
                'id' => 6,
                'name' => '会员单位',
                'slug' => '会员单位',
                'created_at' => '2021-05-12 15:18:20',
                'updated_at' => '2021-05-12 15:18:20',
            ),
            4 =>
            array(
                'id' => 7,
                'name' => '代理商',
                'slug' => '代理商',
                'created_at' => '2021-05-12 15:21:33',
                'updated_at' => '2021-05-12 15:21:33',
            ),
            5 =>
            array(
                'id' => 8,
                'name' => '团队后台',
                'slug' => '团队后台',
                'created_at' => '2021-05-12 15:22:24',
                'updated_at' => '2021-05-12 15:22:24',
            ),
            6 =>
            array(
                'id' => 9,
                'name' => '客服2',
                'slug' => '客服2',
                'created_at' => '2021-07-23 23:50:34',
                'updated_at' => '2021-07-23 23:50:34',
            ),
        ));
    }
}
