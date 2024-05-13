<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-27 17:21:00
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-27 17:24:15
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnDefaultDataForDataAny extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_stai', function (Blueprint $table) {
            $table->integer('pid')->default(0)->change();
        });
        Schema::table('data_tkb', function (Blueprint $table) {
            $table->integer('pid')->default(0)->change();
        });
        Schema::table('data_bt', function (Blueprint $table) {
            $table->integer('pid')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_stai', function (Blueprint $table) {
            $table->integer('pid')->change();
        });
        Schema::table('data_tkb', function (Blueprint $table) {
            $table->integer('pid')->change();
        });
        Schema::table('data_bt', function (Blueprint $table) {
            $table->integer('pid')->change();
        });
    }
}
