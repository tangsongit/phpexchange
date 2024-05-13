<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-11 16:53:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-11 17:40:09
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInvitePoster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invite_poster', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('image', '255')->nullable()->commit('图片');
            $table->boolean('status')->comment('状态');
            $table->boolean('is_default')->comment('默认');
            $table->tinyInteger('sort')->comment('排序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invite_poster');
    }
}
