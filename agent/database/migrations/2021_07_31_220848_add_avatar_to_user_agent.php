<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 22:08:48
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-07-31 22:09:57
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvatarToUserAgent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_agent', function (Blueprint $table) {
            $table->string('avatar')->nullable()->comment('代理头像');
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
            $table->dropColumn('avatar');
        });
    }
}
