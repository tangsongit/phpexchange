<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsideTradeRiskTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inside_trade_risk', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned();
			$table->integer('pair_id')->unsigned()->nullable()->default(0)->comment('交易对ID');
			$table->string('pair_name', 30)->nullable()->comment('交易对名称');
			$table->string('symbol', 30)->nullable()->unique('symbol')->comment('符号');
			$table->boolean('up_or_down')->nullable()->default(1);
			$table->decimal('range', 8, 4)->unsigned()->nullable()->default(0.0000);
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
		Schema::drop('inside_trade_risk');
	}
}
