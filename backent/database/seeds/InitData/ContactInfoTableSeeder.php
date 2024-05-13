<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactInfoTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('contact_info')->delete();

        DB::table('contact_info')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => '联系信息',
                'url' => '	BINVET@163..com',
            ),
            1 =>
            array(
                'id' => 2,
                'name' => '常规咨询',
                'url' => '	BINVET@163..com',
            ),
            2 =>
            array(
                'id' => 3,
                'name' => '客户服务',
                'url' => '	BINVET@163..com',
            ),
            3 =>
            array(
                'id' => 4,
                'name' => '媒体合作',
                'url' => '	BINVET@163..com',
            ),
        ));
    }
}
