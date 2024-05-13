<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 21:56:46
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-07-31 21:59:26
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToUserAgent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_agent', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->comment('代理账号状态');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_agent', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
