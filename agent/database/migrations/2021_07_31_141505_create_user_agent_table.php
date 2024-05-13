<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-31 14:15:05
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-07-31 21:48:57
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_agent', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unique()->comment('用户ID');
            $table->string('remark')->nullable()->comment('代理备注');
            $table->string('name')->nullable()->comment('代理名称');
            $table->string('username')->comment('代理账户,登录代理后台的用户名');
            $table->string('password', 80)->nullable()->comment('代理商后台密码');
            $table->decimal('rebate_rate', 6, 4)->nullable()->comment('返佣倍率(如果其他倍率为空则默认使用该参数)');
            $table->decimal('rebate_rate_exchange', 6, 4)->nullable()->comment('币币分佣比例');
            $table->decimal('rebate_rate_subscribe', 6, 4)->nullable()->comment('申购分佣比例');
            $table->decimal('rebate_rate_contract', 6, 4)->nullable()->comment('合约分佣比例');
            $table->decimal('rebate_rate_option', 6, 4)->nullable()->comment('期权分佣比例');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_agent');
    }
}
