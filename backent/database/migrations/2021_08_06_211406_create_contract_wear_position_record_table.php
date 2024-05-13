<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractWearPositionRecordTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_wear_position_record', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0)->comment('用户ID');
			$table->integer('contract_id')->unsigned()->comment('合约ID');
			$table->string('symbol', 30)->comment('合约symbol');
			$table->boolean('position_side')->comment('仓位方向 1多仓 2空仓');
			$table->string('open_position_price', 30)->nullable()->comment('开仓价');
			$table->string('close_position_price', 30)->nullable()->comment('平仓价');
			$table->string('profit', 30)->comment('盈亏');
			$table->string('settle_profit', 30)->comment('实际结算盈亏');
			$table->string('loss', 30)->nullable();
			$table->integer('ts')->unsigned()->nullable();
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
		Schema::drop('contract_wear_position_record');
	}
}
