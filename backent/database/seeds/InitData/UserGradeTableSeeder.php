<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGradeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('user_grade')->delete();

        DB::table('user_grade')->insert(array(
            0 =>
            array(
                'grade_id' => 1,
                'grade_name' => '普通账户',
                'grade_name_en' => 'Common account',
                'grade_name_tw' => '普通賬戶',
                'grade_img' => NULL,
                'ug_self_vol' => '0',
                'ug_recommend_grade' => 0,
                'ug_recommend_num' => 0,
                'ug_total_vol' => '0',
                'ug_direct_vol' => '0',
                'ug_direct_vol_num' => 0,
                'ug_direct_recharge' => '0',
                'ug_direct_recharge_num' => 0,
                'bonus' => '',
                'status' => 1,
                'created_at' => '2019-04-26 14:33:00',
                'updated_at' => '2019-04-26 14:33:04',
            ),
            1 =>
            array(
                'grade_id' => 2,
                'grade_name' => '期权矿工',
                'grade_name_en' => 'Option miner',
                'grade_name_tw' => '期權礦工',
                'grade_img' => NULL,
                'ug_self_vol' => '0',
                'ug_recommend_grade' => 1,
                'ug_recommend_num' => 5,
                'ug_total_vol' => '0',
                'ug_direct_vol' => '5000',
                'ug_direct_vol_num' => 2,
                'ug_direct_recharge' => '0',
                'ug_direct_recharge_num' => 0,
                'bonus' => '0.005|0.005|0.005',
                'status' => 1,
                'created_at' => '2019-04-26 14:33:06',
                'updated_at' => '2019-04-26 14:33:09',
            ),
            2 =>
            array(
                'grade_id' => 3,
                'grade_name' => '节点矿工',
                'grade_name_en' => 'Node miner',
                'grade_name_tw' => '節點礦工',
                'grade_img' => NULL,
                'ug_self_vol' => '10000',
                'ug_recommend_grade' => 2,
                'ug_recommend_num' => 2,
                'ug_total_vol' => '60000',
                'ug_direct_vol' => '0',
                'ug_direct_vol_num' => 0,
                'ug_direct_recharge' => '0',
                'ug_direct_recharge_num' => 0,
                'bonus' => '0.013|0.013|0.013',
                'status' => 1,
                'created_at' => '2019-04-26 14:33:11',
                'updated_at' => '2019-04-26 14:33:13',
            ),
            3 =>
            array(
                'grade_id' => 4,
                'grade_name' => '高级矿工',
                'grade_name_en' => 'Senior miner',
                'grade_name_tw' => '高級礦工',
                'grade_img' => NULL,
                'ug_self_vol' => '20000',
                'ug_recommend_grade' => 3,
                'ug_recommend_num' => 3,
                'ug_total_vol' => '0',
                'ug_direct_vol' => '150000',
                'ug_direct_vol_num' => 3,
                'ug_direct_recharge' => '0',
                'ug_direct_recharge_num' => 0,
                'bonus' => '0.018|0.018|0.018|0.018',
                'status' => 1,
                'created_at' => '2019-04-26 14:33:15',
                'updated_at' => '2019-04-26 14:33:17',
            ),
            4 =>
            array(
                'grade_id' => 5,
                'grade_name' => '超级矿工',
                'grade_name_en' => 'Super miner',
                'grade_name_tw' => '超級礦工',
                'grade_img' => NULL,
                'ug_self_vol' => '20000',
                'ug_recommend_grade' => 4,
                'ug_recommend_num' => 3,
                'ug_total_vol' => '0',
                'ug_direct_vol' => '0',
                'ug_direct_vol_num' => 0,
                'ug_direct_recharge' => '50000',
                'ug_direct_recharge_num' => 3,
                'bonus' => '0.022|0.022|0.022|0.022',
                'status' => 1,
                'created_at' => '2019-04-26 14:33:20',
                'updated_at' => '2019-04-26 14:33:24',
            ),
            5 =>
            array(
                'grade_id' => 6,
                'grade_name' => '矿池',
                'grade_name_en' => 'Ore pool',
                'grade_name_tw' => '礦池',
                'grade_img' => NULL,
                'ug_self_vol' => '0',
                'ug_recommend_grade' => 5,
                'ug_recommend_num' => 3,
                'ug_total_vol' => '0',
                'ug_direct_vol' => '0',
                'ug_direct_vol_num' => 0,
                'ug_direct_recharge' => '0',
                'ug_direct_recharge_num' => 0,
                'bonus' => '0.025|0.025|0.025|0.025|0.025',
                'status' => 1,
                'created_at' => '2019-04-26 14:33:28',
                'updated_at' => '2019-04-26 14:33:32',
            ),
        ));
    }
}
