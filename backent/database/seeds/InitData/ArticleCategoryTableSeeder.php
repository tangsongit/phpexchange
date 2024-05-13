<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleCategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('article_category')->delete();

        DB::table('article_category')->insert(array(
            0 =>
            array(
                'id' => 1,
                'pid' => 0,
                'order' => 1,
                'created_at' => '2020-06-23 11:43:07',
                'updated_at' => '2020-07-29 21:25:23',
                'deleted_at' => NULL,
                'url' => 'www.baidu.com',
            ),
            1 =>
            array(
                'id' => 2,
                'pid' => 0,
                'order' => 3,
                'created_at' => '2020-06-27 14:45:37',
                'updated_at' => '2020-07-30 05:05:04',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'pid' => 0,
                'order' => 8,
                'created_at' => '2020-06-27 14:45:50',
                'updated_at' => '2020-07-30 05:05:04',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'pid' => 0,
                'order' => 22,
                'created_at' => '2020-06-27 14:46:19',
                'updated_at' => '2020-08-10 12:02:40',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            4 =>
            array(
                'id' => 5,
                'pid' => 0,
                'order' => 13,
                'created_at' => '2020-07-20 23:01:00',
                'updated_at' => '2020-08-10 12:02:38',
                'deleted_at' => NULL,
                'url' => 'www.baidu.com',
            ),
            5 =>
            array(
                'id' => 8,
                'pid' => 2,
                'order' => 7,
                'created_at' => '2020-07-22 18:25:19',
                'updated_at' => '2020-07-30 05:05:04',
                'deleted_at' => NULL,
                'url' => 'http://www.baidu.com',
            ),
            6 =>
            array(
                'id' => 9,
                'pid' => 2,
                'order' => 6,
                'created_at' => '2020-07-22 15:25:31',
                'updated_at' => '2020-07-30 05:05:04',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            7 =>
            array(
                'id' => 10,
                'pid' => 3,
                'order' => 11,
                'created_at' => '2020-07-19 15:26:37',
                'updated_at' => '2020-08-10 12:02:38',
                'deleted_at' => NULL,
                'url' => 'http://www.baidu.com',
            ),
            8 =>
            array(
                'id' => 11,
                'pid' => 3,
                'order' => 10,
                'created_at' => '2020-07-19 15:26:45',
                'updated_at' => '2020-08-10 12:02:38',
                'deleted_at' => NULL,
                'url' => 'http://www.baidu.com',
            ),
            9 =>
            array(
                'id' => 12,
                'pid' => 2,
                'order' => 5,
                'created_at' => '2020-07-22 15:27:32',
                'updated_at' => '2020-07-30 05:05:04',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            10 =>
            array(
                'id' => 13,
                'pid' => 2,
                'order' => 4,
                'created_at' => '2020-07-22 15:27:49',
                'updated_at' => '2020-07-30 05:05:04',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            11 =>
            array(
                'id' => 14,
                'pid' => 1,
                'order' => 2,
                'created_at' => '2020-07-20 00:31:22',
                'updated_at' => '2020-07-30 05:05:04',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            12 =>
            array(
                'id' => 18,
                'pid' => 5,
                'order' => 18,
                'created_at' => '2020-07-20 23:01:36',
                'updated_at' => '2020-08-10 12:02:39',
                'deleted_at' => NULL,
                'url' => 'http://www.baidu.com',
            ),
            13 =>
            array(
                'id' => 19,
                'pid' => 28,
                'order' => 7,
                'created_at' => '2020-07-20 20:15:01',
                'updated_at' => '2020-07-29 23:57:57',
                'deleted_at' => '2020-07-29 23:57:57',
                'url' => 'http://www.baidu.com',
            ),
            14 =>
            array(
                'id' => 20,
                'pid' => 0,
                'order' => 23,
                'created_at' => '2020-07-20 15:49:48',
                'updated_at' => '2020-08-10 12:02:40',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            15 =>
            array(
                'id' => 21,
                'pid' => 5,
                'order' => 19,
                'created_at' => '2020-07-20 23:06:36',
                'updated_at' => '2020-08-10 12:02:39',
                'deleted_at' => NULL,
                'url' => 'http://www.baidu.com',
            ),
            16 =>
            array(
                'id' => 22,
                'pid' => 5,
                'order' => 20,
                'created_at' => '2020-07-20 23:06:50',
                'updated_at' => '2020-08-10 12:02:39',
                'deleted_at' => NULL,
                'url' => 'http://www.baidu.com',
            ),
            17 =>
            array(
                'id' => 23,
                'pid' => 5,
                'order' => 15,
                'created_at' => '2020-07-21 19:17:21',
                'updated_at' => '2020-08-10 12:02:39',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            18 =>
            array(
                'id' => 24,
                'pid' => 5,
                'order' => 14,
                'created_at' => '2020-07-21 19:16:14',
                'updated_at' => '2020-08-10 12:02:38',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            19 =>
            array(
                'id' => 25,
                'pid' => 5,
                'order' => 16,
                'created_at' => '2020-07-21 19:19:12',
                'updated_at' => '2020-08-10 12:02:39',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            20 =>
            array(
                'id' => 26,
                'pid' => 5,
                'order' => 17,
                'created_at' => '2020-07-21 19:19:30',
                'updated_at' => '2020-08-10 12:02:39',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            21 =>
            array(
                'id' => 27,
                'pid' => 3,
                'order' => 12,
                'created_at' => '2020-07-21 22:01:53',
                'updated_at' => '2020-08-10 12:02:38',
                'deleted_at' => NULL,
                'url' => 'http://www.baidu.com',
            ),
            22 =>
            array(
                'id' => 28,
                'pid' => 0,
                'order' => 7,
                'created_at' => '2020-07-22 11:13:21',
                'updated_at' => '2020-07-29 23:57:57',
                'deleted_at' => '2020-07-29 23:57:57',
                'url' => 'http://www.baidu.com',
            ),
            23 =>
            array(
                'id' => 29,
                'pid' => 28,
                'order' => 1,
                'created_at' => '2020-07-22 11:14:03',
                'updated_at' => '2020-07-29 23:57:57',
                'deleted_at' => '2020-07-29 23:57:57',
                'url' => 'http://www.baidu.com',
            ),
            24 =>
            array(
                'id' => 30,
                'pid' => 28,
                'order' => 1,
                'created_at' => '2020-07-22 11:16:06',
                'updated_at' => '2020-07-29 23:57:57',
                'deleted_at' => '2020-07-29 23:57:57',
                'url' => 'http://www.baidu.com',
            ),
            25 =>
            array(
                'id' => 31,
                'pid' => 0,
                'order' => 24,
                'created_at' => '2020-07-22 14:38:42',
                'updated_at' => '2020-08-10 12:02:40',
                'deleted_at' => NULL,
                'url' => 'www.baidu.com',
            ),
            26 =>
            array(
                'id' => 32,
                'pid' => 5,
                'order' => 21,
                'created_at' => '2020-07-30 00:01:41',
                'updated_at' => '2020-08-10 12:02:39',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            27 =>
            array(
                'id' => 33,
                'pid' => 3,
                'order' => 9,
                'created_at' => '2020-07-31 14:45:32',
                'updated_at' => '2020-08-10 12:02:38',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            28 =>
            array(
                'id' => 34,
                'pid' => 0,
                'order' => 25,
                'created_at' => '2020-07-31 21:00:11',
                'updated_at' => '2020-07-31 22:57:06',
                'deleted_at' => '2020-07-31 22:57:06',
                'url' => NULL,
            ),
            29 =>
            array(
                'id' => 35,
                'pid' => 0,
                'order' => 25,
                'created_at' => '2020-08-10 12:02:18',
                'updated_at' => '2020-08-10 12:02:40',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            30 =>
            array(
                'id' => 36,
                'pid' => 0,
                'order' => 255,
                'created_at' => '2020-10-17 10:55:36',
                'updated_at' => '2020-10-17 10:55:36',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
            31 =>
            array(
                'id' => 39,
                'pid' => 4,
                'order' => NULL,
                'created_at' => '2020-11-30 18:21:04',
                'updated_at' => '2020-11-30 18:21:04',
                'deleted_at' => NULL,
                'url' => NULL,
            ),
        ));
    }
}
