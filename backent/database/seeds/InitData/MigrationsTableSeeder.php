<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('migrations')->delete();

        DB::table('migrations')->insert(array(
            0 =>
            array(
                'id' => 1,
                'migration' => '2021_08_06_211406_create_admin_extension_histories_table',
                'batch' => 0,
            ),
            1 =>
            array(
                'id' => 2,
                'migration' => '2021_08_06_211406_create_admin_extensions_table',
                'batch' => 0,
            ),
            2 =>
            array(
                'id' => 3,
                'migration' => '2021_08_06_211406_create_admin_menu_table',
                'batch' => 0,
            ),
            3 =>
            array(
                'id' => 4,
                'migration' => '2021_08_06_211406_create_admin_modify_password_logs_table',
                'batch' => 0,
            ),
            4 =>
            array(
                'id' => 5,
                'migration' => '2021_08_06_211406_create_admin_operation_log_table',
                'batch' => 0,
            ),
            5 =>
            array(
                'id' => 6,
                'migration' => '2021_08_06_211406_create_admin_permission_menu_table',
                'batch' => 0,
            ),
            6 =>
            array(
                'id' => 7,
                'migration' => '2021_08_06_211406_create_admin_permissions_table',
                'batch' => 0,
            ),
            7 =>
            array(
                'id' => 8,
                'migration' => '2021_08_06_211406_create_admin_role_menu_table',
                'batch' => 0,
            ),
            8 =>
            array(
                'id' => 9,
                'migration' => '2021_08_06_211406_create_admin_role_permissions_table',
                'batch' => 0,
            ),
            9 =>
            array(
                'id' => 10,
                'migration' => '2021_08_06_211406_create_admin_role_users_table',
                'batch' => 0,
            ),
            10 =>
            array(
                'id' => 11,
                'migration' => '2021_08_06_211406_create_admin_roles_table',
                'batch' => 0,
            ),
            11 =>
            array(
                'id' => 12,
                'migration' => '2021_08_06_211406_create_admin_setting_table',
                'batch' => 0,
            ),
            12 =>
            array(
                'id' => 13,
                'migration' => '2021_08_06_211406_create_admin_settings_table',
                'batch' => 0,
            ),
            13 =>
            array(
                'id' => 14,
                'migration' => '2021_08_06_211406_create_admin_users_table',
                'batch' => 0,
            ),
            14 =>
            array(
                'id' => 15,
                'migration' => '2021_08_06_211406_create_advice_category_translations_table',
                'batch' => 0,
            ),
            15 =>
            array(
                'id' => 16,
                'migration' => '2021_08_06_211406_create_advices_table',
                'batch' => 0,
            ),
            16 =>
            array(
                'id' => 17,
                'migration' => '2021_08_06_211406_create_advices_category_table',
                'batch' => 0,
            ),
            17 =>
            array(
                'id' => 18,
                'migration' => '2021_08_06_211406_create_agent_admin_menu_table',
                'batch' => 0,
            ),
            18 =>
            array(
                'id' => 19,
                'migration' => '2021_08_06_211406_create_agent_admin_operation_log_table',
                'batch' => 0,
            ),
            19 =>
            array(
                'id' => 20,
                'migration' => '2021_08_06_211406_create_agent_admin_permission_menu_table',
                'batch' => 0,
            ),
            20 =>
            array(
                'id' => 21,
                'migration' => '2021_08_06_211406_create_agent_admin_permissions_table',
                'batch' => 0,
            ),
            21 =>
            array(
                'id' => 22,
                'migration' => '2021_08_06_211406_create_agent_admin_role_menu_table',
                'batch' => 0,
            ),
            22 =>
            array(
                'id' => 23,
                'migration' => '2021_08_06_211406_create_agent_admin_role_permissions_table',
                'batch' => 0,
            ),
            23 =>
            array(
                'id' => 24,
                'migration' => '2021_08_06_211406_create_agent_admin_role_users_table',
                'batch' => 0,
            ),
            24 =>
            array(
                'id' => 25,
                'migration' => '2021_08_06_211406_create_agent_admin_roles_table',
                'batch' => 0,
            ),
            25 =>
            array(
                'id' => 26,
                'migration' => '2021_08_06_211406_create_agent_admin_users_table',
                'batch' => 0,
            ),
            26 =>
            array(
                'id' => 27,
                'migration' => '2021_08_06_211406_create_agent_grade_table',
                'batch' => 0,
            ),
            27 =>
            array(
                'id' => 28,
                'migration' => '2021_08_06_211406_create_agent_users_table',
                'batch' => 0,
            ),
            28 =>
            array(
                'id' => 29,
                'migration' => '2021_08_06_211406_create_app_version_table',
                'batch' => 0,
            ),
            29 =>
            array(
                'id' => 30,
                'migration' => '2021_08_06_211406_create_article_category_table',
                'batch' => 0,
            ),
            30 =>
            array(
                'id' => 31,
                'migration' => '2021_08_06_211406_create_article_translations_table',
                'batch' => 0,
            ),
            31 =>
            array(
                'id' => 32,
                'migration' => '2021_08_06_211406_create_articles_table',
                'batch' => 0,
            ),
            32 =>
            array(
                'id' => 33,
                'migration' => '2021_08_06_211406_create_banner_table',
                'batch' => 0,
            ),
            33 =>
            array(
                'id' => 34,
                'migration' => '2021_08_06_211406_create_banner_translations_table',
                'batch' => 0,
            ),
            34 =>
            array(
                'id' => 35,
                'migration' => '2021_08_06_211406_create_black_list_table',
                'batch' => 0,
            ),
            35 =>
            array(
                'id' => 36,
                'migration' => '2021_08_06_211406_create_block_control_admin_menu_table',
                'batch' => 0,
            ),
            36 =>
            array(
                'id' => 37,
                'migration' => '2021_08_06_211406_create_block_control_admin_operation_log_table',
                'batch' => 0,
            ),
            37 =>
            array(
                'id' => 38,
                'migration' => '2021_08_06_211406_create_block_control_admin_permission_menu_table',
                'batch' => 0,
            ),
            38 =>
            array(
                'id' => 39,
                'migration' => '2021_08_06_211406_create_block_control_admin_permissions_table',
                'batch' => 0,
            ),
            39 =>
            array(
                'id' => 40,
                'migration' => '2021_08_06_211406_create_block_control_admin_role_menu_table',
                'batch' => 0,
            ),
            40 =>
            array(
                'id' => 41,
                'migration' => '2021_08_06_211406_create_block_control_admin_role_permissions_table',
                'batch' => 0,
            ),
            41 =>
            array(
                'id' => 42,
                'migration' => '2021_08_06_211406_create_block_control_admin_role_users_table',
                'batch' => 0,
            ),
            42 =>
            array(
                'id' => 43,
                'migration' => '2021_08_06_211406_create_block_control_admin_roles_table',
                'batch' => 0,
            ),
            43 =>
            array(
                'id' => 44,
                'migration' => '2021_08_06_211406_create_block_control_admin_users_table',
                'batch' => 0,
            ),
            44 =>
            array(
                'id' => 45,
                'migration' => '2021_08_06_211406_create_bonus_logs_table',
                'batch' => 0,
            ),
            45 =>
            array(
                'id' => 46,
                'migration' => '2021_08_06_211406_create_category_translations_table',
                'batch' => 0,
            ),
            46 =>
            array(
                'id' => 47,
                'migration' => '2021_08_06_211406_create_center_wallet_table',
                'batch' => 0,
            ),
            47 =>
            array(
                'id' => 48,
                'migration' => '2021_08_06_211406_create_coin_config_table',
                'batch' => 0,
            ),
            48 =>
            array(
                'id' => 49,
                'migration' => '2021_08_06_211406_create_coins_table',
                'batch' => 0,
            ),
            49 =>
            array(
                'id' => 50,
                'migration' => '2021_08_06_211406_create_collect_table',
                'batch' => 0,
            ),
            50 =>
            array(
                'id' => 51,
                'migration' => '2021_08_06_211406_create_contact_info_table',
                'batch' => 0,
            ),
            51 =>
            array(
                'id' => 52,
                'migration' => '2021_08_06_211406_create_contract_account_table',
                'batch' => 0,
            ),
            52 =>
            array(
                'id' => 53,
                'migration' => '2021_08_06_211406_create_contract_deal_robot_table',
                'batch' => 0,
            ),
            53 =>
            array(
                'id' => 54,
                'migration' => '2021_08_06_211406_create_contract_entrust_table',
                'batch' => 0,
            ),
            54 =>
            array(
                'id' => 55,
                'migration' => '2021_08_06_211406_create_contract_order_table',
                'batch' => 0,
            ),
            55 =>
            array(
                'id' => 56,
                'migration' => '2021_08_06_211406_create_contract_pair_table',
                'batch' => 0,
            ),
            56 =>
            array(
                'id' => 57,
                'migration' => '2021_08_06_211406_create_contract_position_table',
                'batch' => 0,
            ),
            57 =>
            array(
                'id' => 58,
                'migration' => '2021_08_06_211406_create_contract_rebate_table',
                'batch' => 0,
            ),
            58 =>
            array(
                'id' => 59,
                'migration' => '2021_08_06_211406_create_contract_share_table',
                'batch' => 0,
            ),
            59 =>
            array(
                'id' => 60,
                'migration' => '2021_08_06_211406_create_contract_strategy_table',
                'batch' => 0,
            ),
            60 =>
            array(
                'id' => 61,
                'migration' => '2021_08_06_211406_create_contract_wear_position_record_table',
                'batch' => 0,
            ),
            61 =>
            array(
                'id' => 62,
                'migration' => '2021_08_06_211406_create_country_table',
                'batch' => 0,
            ),
            62 =>
            array(
                'id' => 63,
                'migration' => '2021_08_06_211406_create_data_bt_table',
                'batch' => 0,
            ),
            63 =>
            array(
                'id' => 64,
                'migration' => '2021_08_06_211406_create_data_stai_table',
                'batch' => 0,
            ),
            64 =>
            array(
                'id' => 65,
                'migration' => '2021_08_06_211406_create_data_tkb_table',
                'batch' => 0,
            ),
            65 =>
            array(
                'id' => 66,
                'migration' => '2021_08_06_211406_create_failed_jobs_table',
                'batch' => 0,
            ),
            66 =>
            array(
                'id' => 67,
                'migration' => '2021_08_06_211406_create_inside_trade_buy_table',
                'batch' => 0,
            ),
            67 =>
            array(
                'id' => 68,
                'migration' => '2021_08_06_211406_create_inside_trade_deal_robot_table',
                'batch' => 0,
            ),
            68 =>
            array(
                'id' => 69,
                'migration' => '2021_08_06_211406_create_inside_trade_order_table',
                'batch' => 0,
            ),
            69 =>
            array(
                'id' => 70,
                'migration' => '2021_08_06_211406_create_inside_trade_pair_table',
                'batch' => 0,
            ),
            70 =>
            array(
                'id' => 71,
                'migration' => '2021_08_06_211406_create_inside_trade_risk_table',
                'batch' => 0,
            ),
            71 =>
            array(
                'id' => 72,
                'migration' => '2021_08_06_211406_create_inside_trade_robot_table',
                'batch' => 0,
            ),
            72 =>
            array(
                'id' => 73,
                'migration' => '2021_08_06_211406_create_inside_trade_sell_table',
                'batch' => 0,
            ),
            73 =>
            array(
                'id' => 74,
                'migration' => '2021_08_06_211406_create_jobs_table',
                'batch' => 0,
            ),
            74 =>
            array(
                'id' => 75,
                'migration' => '2021_08_06_211406_create_navigation_table',
                'batch' => 0,
            ),
            75 =>
            array(
                'id' => 76,
                'migration' => '2021_08_06_211406_create_navigation_translations_table',
                'batch' => 0,
            ),
            76 =>
            array(
                'id' => 77,
                'migration' => '2021_08_06_211406_create_notifications_table',
                'batch' => 0,
            ),
            77 =>
            array(
                'id' => 78,
                'migration' => '2021_08_06_211406_create_option_bet_coin_table',
                'batch' => 0,
            ),
            78 =>
            array(
                'id' => 79,
                'migration' => '2021_08_06_211406_create_option_pair_table',
                'batch' => 0,
            ),
            79 =>
            array(
                'id' => 80,
                'migration' => '2021_08_06_211406_create_option_scene_table',
                'batch' => 0,
            ),
            80 =>
            array(
                'id' => 81,
                'migration' => '2021_08_06_211406_create_option_scene_order_table',
                'batch' => 0,
            ),
            81 =>
            array(
                'id' => 82,
                'migration' => '2021_08_06_211406_create_option_time_table',
                'batch' => 0,
            ),
            82 =>
            array(
                'id' => 83,
                'migration' => '2021_08_06_211406_create_otc_account_table',
                'batch' => 0,
            ),
            83 =>
            array(
                'id' => 84,
                'migration' => '2021_08_06_211406_create_otc_appeal_table',
                'batch' => 0,
            ),
            84 =>
            array(
                'id' => 85,
                'migration' => '2021_08_06_211406_create_otc_coinlist_table',
                'batch' => 0,
            ),
            85 =>
            array(
                'id' => 86,
                'migration' => '2021_08_06_211406_create_otc_entrust_table',
                'batch' => 0,
            ),
            86 =>
            array(
                'id' => 87,
                'migration' => '2021_08_06_211406_create_otc_order_table',
                'batch' => 0,
            ),
            87 =>
            array(
                'id' => 88,
                'migration' => '2021_08_06_211406_create_performance_table',
                'batch' => 0,
            ),
            88 =>
            array(
                'id' => 89,
                'migration' => '2021_08_06_211406_create_recharge_manual_table',
                'batch' => 0,
            ),
            89 =>
            array(
                'id' => 90,
                'migration' => '2021_08_06_211406_create_subscribe_activity_table',
                'batch' => 0,
            ),
            90 =>
            array(
                'id' => 91,
                'migration' => '2021_08_06_211406_create_translate_table',
                'batch' => 0,
            ),
            91 =>
            array(
                'id' => 92,
                'migration' => '2021_08_06_211406_create_user_agreement_logs_table',
                'batch' => 0,
            ),
            92 =>
            array(
                'id' => 93,
                'migration' => '2021_08_06_211406_create_user_auth_table',
                'batch' => 0,
            ),
            93 =>
            array(
                'id' => 94,
                'migration' => '2021_08_06_211406_create_user_grade_table',
                'batch' => 0,
            ),
            94 =>
            array(
                'id' => 95,
                'migration' => '2021_08_06_211406_create_user_login_logs_table',
                'batch' => 0,
            ),
            95 =>
            array(
                'id' => 96,
                'migration' => '2021_08_06_211406_create_user_payments_table',
                'batch' => 0,
            ),
            96 =>
            array(
                'id' => 97,
                'migration' => '2021_08_06_211406_create_user_subscribe_table',
                'batch' => 0,
            ),
            97 =>
            array(
                'id' => 98,
                'migration' => '2021_08_06_211406_create_user_subscribe_record_table',
                'batch' => 0,
            ),
            98 =>
            array(
                'id' => 99,
                'migration' => '2021_08_06_211406_create_user_transfer_record_table',
                'batch' => 0,
            ),
            99 =>
            array(
                'id' => 100,
                'migration' => '2021_08_06_211406_create_user_transfer_translation_table',
                'batch' => 0,
            ),
            100 =>
            array(
                'id' => 101,
                'migration' => '2021_08_06_211406_create_user_upgrade_logs_table',
                'batch' => 0,
            ),
            101 =>
            array(
                'id' => 102,
                'migration' => '2021_08_06_211406_create_user_wallet_table',
                'batch' => 0,
            ),
            102 =>
            array(
                'id' => 103,
                'migration' => '2021_08_06_211406_create_user_wallet_logs_table',
                'batch' => 0,
            ),
            103 =>
            array(
                'id' => 104,
                'migration' => '2021_08_06_211406_create_user_wallet_recharge_table',
                'batch' => 0,
            ),
            104 =>
            array(
                'id' => 105,
                'migration' => '2021_08_06_211406_create_user_wallet_withdraw_table',
                'batch' => 0,
            ),
            105 =>
            array(
                'id' => 106,
                'migration' => '2021_08_06_211406_create_user_withdrawal_management_table',
                'batch' => 0,
            ),
            106 =>
            array(
                'id' => 107,
                'migration' => '2021_08_06_211406_create_users_table',
                'batch' => 0,
            ),
            107 =>
            array(
                'id' => 108,
                'migration' => '2021_08_06_211406_create_wallet_collection_table',
                'batch' => 0,
            ),
            108 =>
            array(
                'id' => 109,
                'migration' => '2021_08_06_211406_create_xy_bank_table',
                'batch' => 0,
            ),
        ));
    }
}
