<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRolePermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('admin_role_permissions')->delete();

        DB::table('admin_role_permissions')->insert(array(
            0 =>
            array(
                'role_id' => 3,
                'permission_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'role_id' => 3,
                'permission_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array(
                'role_id' => 3,
                'permission_id' => 11,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 =>
            array(
                'role_id' => 3,
                'permission_id' => 12,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 =>
            array(
                'role_id' => 3,
                'permission_id' => 17,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 =>
            array(
                'role_id' => 3,
                'permission_id' => 19,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 =>
            array(
                'role_id' => 3,
                'permission_id' => 39,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 =>
            array(
                'role_id' => 3,
                'permission_id' => 40,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 =>
            array(
                'role_id' => 3,
                'permission_id' => 42,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 =>
            array(
                'role_id' => 3,
                'permission_id' => 43,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 =>
            array(
                'role_id' => 3,
                'permission_id' => 44,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 =>
            array(
                'role_id' => 3,
                'permission_id' => 45,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 =>
            array(
                'role_id' => 3,
                'permission_id' => 46,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 =>
            array(
                'role_id' => 3,
                'permission_id' => 47,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 =>
            array(
                'role_id' => 3,
                'permission_id' => 54,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 =>
            array(
                'role_id' => 3,
                'permission_id' => 72,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 =>
            array(
                'role_id' => 3,
                'permission_id' => 73,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 =>
            array(
                'role_id' => 4,
                'permission_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 =>
            array(
                'role_id' => 4,
                'permission_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 =>
            array(
                'role_id' => 4,
                'permission_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 =>
            array(
                'role_id' => 4,
                'permission_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 =>
            array(
                'role_id' => 4,
                'permission_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 =>
            array(
                'role_id' => 4,
                'permission_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 =>
            array(
                'role_id' => 4,
                'permission_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 =>
            array(
                'role_id' => 4,
                'permission_id' => 11,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 =>
            array(
                'role_id' => 4,
                'permission_id' => 12,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 =>
            array(
                'role_id' => 4,
                'permission_id' => 13,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 =>
            array(
                'role_id' => 4,
                'permission_id' => 15,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 =>
            array(
                'role_id' => 4,
                'permission_id' => 17,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 =>
            array(
                'role_id' => 4,
                'permission_id' => 18,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 =>
            array(
                'role_id' => 4,
                'permission_id' => 19,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 =>
            array(
                'role_id' => 4,
                'permission_id' => 20,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 =>
            array(
                'role_id' => 4,
                'permission_id' => 21,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 =>
            array(
                'role_id' => 4,
                'permission_id' => 22,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 =>
            array(
                'role_id' => 4,
                'permission_id' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 =>
            array(
                'role_id' => 4,
                'permission_id' => 26,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 =>
            array(
                'role_id' => 4,
                'permission_id' => 27,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 =>
            array(
                'role_id' => 4,
                'permission_id' => 28,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 =>
            array(
                'role_id' => 4,
                'permission_id' => 30,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 =>
            array(
                'role_id' => 4,
                'permission_id' => 31,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 =>
            array(
                'role_id' => 4,
                'permission_id' => 32,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 =>
            array(
                'role_id' => 4,
                'permission_id' => 33,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 =>
            array(
                'role_id' => 4,
                'permission_id' => 36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 =>
            array(
                'role_id' => 4,
                'permission_id' => 37,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 =>
            array(
                'role_id' => 4,
                'permission_id' => 39,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 =>
            array(
                'role_id' => 4,
                'permission_id' => 40,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 =>
            array(
                'role_id' => 4,
                'permission_id' => 42,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 =>
            array(
                'role_id' => 4,
                'permission_id' => 43,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 =>
            array(
                'role_id' => 4,
                'permission_id' => 44,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 =>
            array(
                'role_id' => 4,
                'permission_id' => 45,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 =>
            array(
                'role_id' => 4,
                'permission_id' => 46,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 =>
            array(
                'role_id' => 4,
                'permission_id' => 47,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 =>
            array(
                'role_id' => 4,
                'permission_id' => 48,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 =>
            array(
                'role_id' => 4,
                'permission_id' => 49,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 =>
            array(
                'role_id' => 4,
                'permission_id' => 50,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 =>
            array(
                'role_id' => 4,
                'permission_id' => 51,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 =>
            array(
                'role_id' => 4,
                'permission_id' => 52,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 =>
            array(
                'role_id' => 4,
                'permission_id' => 53,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 =>
            array(
                'role_id' => 4,
                'permission_id' => 54,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 =>
            array(
                'role_id' => 4,
                'permission_id' => 56,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 =>
            array(
                'role_id' => 4,
                'permission_id' => 57,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 =>
            array(
                'role_id' => 4,
                'permission_id' => 58,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 =>
            array(
                'role_id' => 4,
                'permission_id' => 59,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 =>
            array(
                'role_id' => 4,
                'permission_id' => 60,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 =>
            array(
                'role_id' => 4,
                'permission_id' => 61,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 =>
            array(
                'role_id' => 4,
                'permission_id' => 62,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 =>
            array(
                'role_id' => 4,
                'permission_id' => 72,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 =>
            array(
                'role_id' => 4,
                'permission_id' => 73,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 =>
            array(
                'role_id' => 6,
                'permission_id' => 11,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 =>
            array(
                'role_id' => 6,
                'permission_id' => 15,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            70 =>
            array(
                'role_id' => 6,
                'permission_id' => 17,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            71 =>
            array(
                'role_id' => 6,
                'permission_id' => 21,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            72 =>
            array(
                'role_id' => 6,
                'permission_id' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            73 =>
            array(
                'role_id' => 6,
                'permission_id' => 26,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            74 =>
            array(
                'role_id' => 6,
                'permission_id' => 27,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            75 =>
            array(
                'role_id' => 6,
                'permission_id' => 36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            76 =>
            array(
                'role_id' => 6,
                'permission_id' => 37,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            77 =>
            array(
                'role_id' => 6,
                'permission_id' => 49,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            78 =>
            array(
                'role_id' => 6,
                'permission_id' => 50,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 =>
            array(
                'role_id' => 6,
                'permission_id' => 51,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 =>
            array(
                'role_id' => 6,
                'permission_id' => 52,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 =>
            array(
                'role_id' => 6,
                'permission_id' => 53,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 =>
            array(
                'role_id' => 6,
                'permission_id' => 54,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 =>
            array(
                'role_id' => 6,
                'permission_id' => 73,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            84 =>
            array(
                'role_id' => 7,
                'permission_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            85 =>
            array(
                'role_id' => 7,
                'permission_id' => 11,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            86 =>
            array(
                'role_id' => 7,
                'permission_id' => 12,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            87 =>
            array(
                'role_id' => 7,
                'permission_id' => 13,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            88 =>
            array(
                'role_id' => 7,
                'permission_id' => 15,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            89 =>
            array(
                'role_id' => 7,
                'permission_id' => 17,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            90 =>
            array(
                'role_id' => 7,
                'permission_id' => 18,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            91 =>
            array(
                'role_id' => 7,
                'permission_id' => 19,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            92 =>
            array(
                'role_id' => 7,
                'permission_id' => 20,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            93 =>
            array(
                'role_id' => 7,
                'permission_id' => 21,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            94 =>
            array(
                'role_id' => 7,
                'permission_id' => 22,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            95 =>
            array(
                'role_id' => 7,
                'permission_id' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            96 =>
            array(
                'role_id' => 7,
                'permission_id' => 26,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            97 =>
            array(
                'role_id' => 7,
                'permission_id' => 27,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            98 =>
            array(
                'role_id' => 7,
                'permission_id' => 28,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            99 =>
            array(
                'role_id' => 7,
                'permission_id' => 36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            100 =>
            array(
                'role_id' => 7,
                'permission_id' => 37,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            101 =>
            array(
                'role_id' => 7,
                'permission_id' => 47,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            102 =>
            array(
                'role_id' => 7,
                'permission_id' => 49,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            103 =>
            array(
                'role_id' => 7,
                'permission_id' => 50,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            104 =>
            array(
                'role_id' => 7,
                'permission_id' => 51,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            105 =>
            array(
                'role_id' => 7,
                'permission_id' => 52,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            106 =>
            array(
                'role_id' => 7,
                'permission_id' => 53,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            107 =>
            array(
                'role_id' => 7,
                'permission_id' => 54,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            108 =>
            array(
                'role_id' => 7,
                'permission_id' => 62,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            109 =>
            array(
                'role_id' => 7,
                'permission_id' => 72,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            110 =>
            array(
                'role_id' => 7,
                'permission_id' => 73,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            111 =>
            array(
                'role_id' => 8,
                'permission_id' => 12,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            112 =>
            array(
                'role_id' => 9,
                'permission_id' => 12,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
    }
}
