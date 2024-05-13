<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractDealRobotTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_deal_robot', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned();
			$table->integer('contract_id')->unsigned()->nullable()->default(0)->comment('合约ID');
			$table->string('symbol', 30)->nullable()->unique('symbol')->comment('符号');
			$table->decimal('bid_plus_unit', 8, 4)->unsigned()->nullable()->default(0.0000)->comment('买单价格向上波动单位');
			$table->integer('bid_plus_count')->unsigned()->nullable()->default(0)->comment('买单价格向上波动计数');
			$table->decimal('bid_minus_unit', 8, 4)->unsigned()->nullable()->default(0.0000)->comment('买单价格向下波动单位');
			$table->integer('bid_minus_count')->unsigned()->nullable()->default(0)->comment('买单价格向下波动计数');
			$table->decimal('ask_plus_unit', 8, 4)->unsigned()->nullable()->default(0.0000)->comment('卖单价格向上波动单位');
			$table->integer('ask_plus_count')->unsigned()->nullable()->default(0)->comment('卖单价格向上波动计数');
			$table->decimal('ask_minus_unit', 8, 4)->unsigned()->nullable()->default(0.0000)->comment('卖单价格向下波动单位');
			$table->integer('ask_minus_count')->unsigned()->nullable()->default(0)->comment('卖单价格向下波动计数');
			$table->boolean('status')->default(0)->comment('0关闭 1开启');
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
		Schema::drop('contract_deal_robot');
	}
}
