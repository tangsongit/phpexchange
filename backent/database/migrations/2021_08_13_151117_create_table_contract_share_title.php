<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-13 15:11:17
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-13 15:27:59
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableContractShareTitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_share_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_share_id')->comment('合约分享ID');
            $table->string('locale')->comment('语言');
            $table->string('title')->nullable()->comment('标题');
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
        Schema::dropIfExists('contract_share_translations');
    }
}
