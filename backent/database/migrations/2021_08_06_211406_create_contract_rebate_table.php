<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-06 21:14:07
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 15:10:18
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
			$table->integer('aid')->default(0)->comment('所属代理商UID');
			$table->integer('user_id')->comment('用户UID(下单的用户ID)');
			$table->integer('user_referrer')->nullable()->comment('代理商UID(佣金的代理ID)');
			$table->integer('deep')->nullable()->comment('代理商层级(1为直推2为间推3为间推的间推以此类推)');
			$table->string('rebate_type', 50)->default('')->comment('返佣类型(1直推返佣，2间推返佣)');
			$table->string('contract_pair')->default('')->comment('合约币对');
			$table->boolean('side')->comment('成交方向(1买入2卖出)');
			$table->decimal('margin', 20, 8)->comment('委托保证金(USDT)');
			$table->decimal('fee', 20, 8)->comment('手续费数量');
			$table->decimal('rebate_rate', 10, 8)->comment('返佣率');
			$table->decimal('rebate', 20, 8)->comment('返还佣金');
			$table->boolean('status')->default(0)->comment('结算状态(0未结算1已结算)');
			$table->timestamp('order_time')->nullable()->comment('下单时间');
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
		Schema::drop('contract_rebate');
	}
}
