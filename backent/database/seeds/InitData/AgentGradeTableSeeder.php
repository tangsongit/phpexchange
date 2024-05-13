<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentGradeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('agent_grade')->delete();

        DB::table('agent_grade')->insert(array(
            0 =>
            array(
                'id' => 1,
                'key' => '0',
                'value' => 'A5',
                'created_at' => '2020-08-14 13:09:13',
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'key' => '1',
                'value' => 'A4',
                'created_at' => '2020-08-14 13:09:16',
                'updated_at' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'key' => '2',
                'value' => 'A3',
                'created_at' => '2020-08-14 13:09:18',
                'updated_at' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'key' => '3',
                'value' => 'A2',
                'created_at' => '2020-08-14 13:09:19',
                'updated_at' => NULL,
            ),
            4 =>
            array(
                'id' => 5,
                'key' => '4',
                'value' => 'A1',
                'created_at' => '2020-08-14 13:09:20',
                'updated_at' => NULL,
            ),
        ));
    }
}
