<?php
/*
 * @Descripttion: 初始化数据
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 18:28:40
 */

use Database\Seeds\InitData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(InitData\ArticleTranslationsTableSeeder::class);
        $this->call(InitData\XyBankTableSeeder::class);
        $this->call(InitData\CoinsTableSeeder::class);
        $this->call(InitData\CountryTableSeeder::class);
        $this->call(InitData\ArticlesTableSeeder::class);
        $this->call(InitData\AdminRolePermissionsTableSeeder::class);
        $this->call(InitData\MigrationsTableSeeder::class);
        $this->call(InitData\AdminPermissionMenuTableSeeder::class);
        $this->call(InitData\BannerTranslationsTableSeeder::class);
        $this->call(InitData\CategoryTranslationsTableSeeder::class);
        $this->call(InitData\AdminPermissionsTableSeeder::class);
        $this->call(InitData\AgentAdminRoleMenuTableSeeder::class);
        $this->call(InitData\AdminMenuTableSeeder::class);
        $this->call(InitData\InsideTradePairTableSeeder::class);
        $this->call(InitData\NavigationTranslationsTableSeeder::class);
        $this->call(InitData\AgentAdminMenuTableSeeder::class);
        $this->call(InitData\AgentAdminPermissionsTableSeeder::class);
        $this->call(InitData\ArticleCategoryTableSeeder::class);
        $this->call(InitData\AdminSettingTableSeeder::class);
        $this->call(InitData\AdviceCategoryTranslationsTableSeeder::class);
        $this->call(InitData\AgentAdminRolePermissionsTableSeeder::class);
        $this->call(InitData\ContractPairTableSeeder::class);
        $this->call(InitData\NavigationTableSeeder::class);
        $this->call(InitData\BlockControlAdminMenuTableSeeder::class);
        $this->call(InitData\AdvicesCategoryTableSeeder::class);
        $this->call(InitData\BannerTableSeeder::class);
        $this->call(InitData\AdminRolesTableSeeder::class);
        $this->call(InitData\UserGradeTableSeeder::class);
        $this->call(InitData\ContractShareTableSeeder::class);
        $this->call(InitData\BlockControlAdminPermissionsTableSeeder::class);
        $this->call(InitData\OptionTimeTableSeeder::class);
        $this->call(InitData\OptionPairTableSeeder::class);
        $this->call(InitData\OptionBetCoinTableSeeder::class);
        $this->call(InitData\CoinConfigTableSeeder::class);
        $this->call(InitData\AgentGradeTableSeeder::class);
        $this->call(InitData\TranslateTableSeeder::class);
        $this->call(InitData\ContactInfoTableSeeder::class);
        $this->call(InitData\CenterWalletTableSeeder::class);
        $this->call(InitData\OtcCoinlistTableSeeder::class);
        $this->call(InitData\AgentAdminRolesTableSeeder::class);
        $this->call(InitData\AdminRoleMenuTableSeeder::class);
        $this->call(InitData\AppVersionTableSeeder::class);
        $this->call(InitData\AdminUsersTableSeeder::class);
        $this->call(InitData\AdminRoleUsersTableSeeder::class);
    }
}
