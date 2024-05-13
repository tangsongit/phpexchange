<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsideTradeRobotTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inside_trade_robot', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned();
			$table->integer('pair_id')->unsigned()->default(0)->comment('交易对ID');
			$table->string('symbol', 30)->nullable()->unique('symbol')->comment('符号');
			$table->decimal('order_amount', 12, 4)->unsigned()->nullable()->default(0.0000)->comment('下单金额');
			$table->decimal('bid_place_threshold', 8, 4)->nullable()->default(0.0000)->comment('买单价格比率');
			$table->decimal('ask_place_threshold', 8, 4)->nullable()->default(0.0000)->comment('卖单价格比率');
			$table->boolean('status')->default(0)->comment('0关闭 1开启');
			$table->integer('start_time')->unsigned()->nullable()->default(0)->comment('开始时间');
			$table->integer('end_time')->unsigned()->nullable()->default(0)->comment('结束时间 0表示一直运行');
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
		Schema::drop('inside_trade_robot');
	}
}
