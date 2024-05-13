<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NavigationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('navigation')->delete();

        DB::table('navigation')->insert(array(
            0 =>
            array(
                'id' => 11,
                'type' => 1,
                'img' => 'images/089bce69ceb4ffbd1f3730925a6716b8.jpg',
                'link_type' => '/exchange',
                'link_data' => NULL,
                'desc' => NULL,
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-08-05 10:36:40',
                'updated_at' => '2020-08-05 11:18:15',
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id' => 12,
                'type' => 1,
                'img' => NULL,
                'link_type' => '/market',
                'link_data' => NULL,
                'desc' => NULL,
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-08-05 11:32:12',
                'updated_at' => '2020-08-05 11:32:12',
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id' => 13,
                'type' => 1,
                'img' => NULL,
                'link_type' => '/newProduct',
                'link_data' => NULL,
                'desc' => NULL,
                'order' => 3,
                'status' => 1,
                'created_at' => '2020-08-05 11:36:10',
                'updated_at' => '2020-08-05 11:37:33',
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'id' => 14,
                'type' => 1,
                'img' => NULL,
                'link_type' => '/purchase',
                'link_data' => NULL,
                'desc' => NULL,
                'order' => 4,
                'status' => 1,
                'created_at' => '2020-08-05 11:43:54',
                'updated_at' => '2020-08-05 11:47:25',
                'deleted_at' => NULL,
            ),
            4 =>
            array(
                'id' => 15,
                'type' => 1,
                'img' => NULL,
                'link_type' => '/college',
                'link_data' => NULL,
                'desc' => NULL,
                'order' => 5,
                'status' => 1,
                'created_at' => '2020-08-05 11:45:50',
                'updated_at' => '2020-08-05 11:45:50',
                'deleted_at' => NULL,
            ),
            5 =>
            array(
                'id' => 17,
                'type' => 2,
                'img' => NULL,
                'link_type' => '/service/10',
                'link_data' => NULL,
                'desc' => NULL,
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-08-05 14:58:11',
                'updated_at' => '2020-08-05 14:58:11',
                'deleted_at' => NULL,
            ),
            6 =>
            array(
                'id' => 18,
                'type' => 2,
                'img' => NULL,
                'link_type' => '/service/11',
                'link_data' => NULL,
                'desc' => NULL,
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-08-05 15:00:04',
                'updated_at' => '2020-08-05 16:08:39',
                'deleted_at' => NULL,
            ),
            7 =>
            array(
                'id' => 19,
                'type' => 2,
                'img' => NULL,
                'link_type' => '/service/27',
                'link_data' => NULL,
                'desc' => NULL,
                'order' => 3,
                'status' => 1,
                'created_at' => '2020-08-05 15:01:23',
                'updated_at' => '2020-08-05 15:01:23',
                'deleted_at' => NULL,
            ),
            8 =>
            array(
                'id' => 20,
                'type' => 2,
                'img' => NULL,
                'link_type' => '/service/33',
                'link_data' => NULL,
                'desc' => NULL,
                'order' => 5,
                'status' => 1,
                'created_at' => '2020-08-05 16:10:24',
                'updated_at' => '2020-08-05 16:10:24',
                'deleted_at' => NULL,
            ),
            9 =>
            array(
                'id' => 21,
                'type' => 3,
                'img' => NULL,
                'link_type' => '/college/list/18',
                'link_data' => NULL,
                'desc' => NULL,
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-08-05 16:11:40',
                'updated_at' => '2020-08-05 16:11:40',
                'deleted_at' => NULL,
            ),
            10 =>
            array(
                'id' => 22,
                'type' => 3,
                'img' => NULL,
                'link_type' => '/college/list/22',
                'link_data' => NULL,
                'desc' => NULL,
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-08-05 16:12:30',
                'updated_at' => '2020-08-05 16:12:30',
                'deleted_at' => NULL,
            ),
            11 =>
            array(
                'id' => 23,
                'type' => 3,
                'img' => NULL,
                'link_type' => '/college/list/32',
                'link_data' => NULL,
                'desc' => NULL,
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-08-05 16:13:25',
                'updated_at' => '2020-08-05 16:13:25',
                'deleted_at' => NULL,
            ),
            12 =>
            array(
                'id' => 24,
                'type' => 1,
                'img' => NULL,
                'link_type' => 'http://chain.segi.bz/house',
                'link_data' => 'http://chain.segi.bz/house',
                'desc' => NULL,
                'order' => 1,
                'status' => 1,
                'created_at' => '2021-04-20 21:33:05',
                'updated_at' => '2021-04-20 21:36:30',
                'deleted_at' => NULL,
            ),
        ));
    }
}
