<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-02 17:55:30
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-02 17:57:38
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractRebateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_rebate', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no')->default('')->comment('订单ID');
            $table->integer('user_id')->comment('用户UID(下单的用户ID)');
            $table->integer('user_referrer')->nullable()->comment('代理商UID(佣金的代理ID)');
            $table->integer('deep')->nullable()->comment('代理商层级(1为直推2为间推3为间推的间推以此类推)');
            $table->tinyInteger('rebate_type')->comment('返佣类型(1直推返佣，2间推返佣)');
            $table->string('contract_pair')->default('')->comment('合约币对');
            $table->tinyInteger('side')->comment('成交方向(1买入2卖出)');
            $table->decimal('amount', 20, 8)->comment('成交金额(USDT)');
            $table->decimal('fee', 20, 8)->comment('手续费数量');
            $table->decimal('rebate_rate', 10, 8)->comment('返佣率');
            $table->tinyInteger('status')->default('0')->comment('结算状态(0未结算1已结算)');
            $table->string('order_time')->nullable()->comment('下单时间');
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
        Schema::dropIfExists('contract_rebate');
    }
}
