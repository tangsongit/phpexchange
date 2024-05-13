<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdvicesCategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('advices_category')->delete();

        DB::table('advices_category')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => '登录&注册',
                'status' => 0,
                'order' => 6,
            ),
            1 =>
            array(
                'id' => 2,
                'name' => '现货交易相关咨询',
                'status' => 1,
                'order' => 5,
            ),
            2 =>
            array(
                'id' => 3,
                'name' => '合约交易相关咨询',
                'status' => 1,
                'order' => 4,
            ),
            3 =>
            array(
                'id' => 4,
                'name' => '账户&安全',
                'status' => 0,
                'order' => 7,
            ),
            4 =>
            array(
                'id' => 5,
                'name' => '充值&提币',
                'status' => 1,
                'order' => 3,
            ),
            5 =>
            array(
                'id' => 6,
                'name' => '个人账户认证咨询',
                'status' => 1,
                'order' => 1,
            ),
            6 =>
            array(
                'id' => 7,
                'name' => '企业账户认证咨询',
                'status' => 1,
                'order' => 2,
            ),
            7 =>
            array(
                'id' => 8,
                'name' => '其他',
                'status' => 1,
                'order' => 10,
            ),
        ));
    }
}
