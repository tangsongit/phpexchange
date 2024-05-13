<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinConfigTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coin_config', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned()->comment('id');
			$table->string('symbol', 30)->comment('产品代码');
			$table->dateTime('datetime')->nullable()->comment('日期时间');
			$table->string('name', 30)->nullable()->default('')->comment('产品名称');
			$table->float('open', 18, 5)->nullable()->default(0.00000)->comment('开盘价');
			$table->float('high', 18, 5)->nullable()->default(0.00000)->comment('最高价');
			$table->float('low', 18, 5)->nullable()->default(0.00000)->comment('最低价');
			$table->float('close', 18, 5)->nullable()->default(0.00000)->comment('最新价');
			$table->float('min_amount', 18, 5)->unsigned()->nullable()->default(0.00000)->comment('最小成交额');
			$table->float('max_amount', 18, 5)->unsigned()->nullable()->default(0.00000)->comment('最大成交额');
			$table->boolean('status')->nullable()->default(0);
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
		Schema::drop('coin_config');
	}
}
