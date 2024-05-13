<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-14 14:25:43
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-14 14:28:37
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDecimalFromOptionScene extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('option_scene', function (Blueprint $table) {
            $table->decimal('delivery_range', 17, 8)->change();
        });
        Schema::table('option_scene_order', function (Blueprint $table) {
            $table->decimal('range', 17, 8)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('option_scene', function (Blueprint $table) {
            $table->decimal('delivery_range', 12, 3)->change();
        });
        Schema::table('option_scene_order', function (Blueprint $table) {
            $table->decimal('drange', 12, 3)->change();
        });
    }
}
