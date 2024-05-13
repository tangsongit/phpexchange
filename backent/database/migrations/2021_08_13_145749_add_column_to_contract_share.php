<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-13 14:57:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-13 15:56:42
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToContractShare extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_share', function (Blueprint $table) {
            $table->tinyInteger('type')->after('peri_img')->nullable()->default(1)->comment('涨跌 1涨 2跌');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_share', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
