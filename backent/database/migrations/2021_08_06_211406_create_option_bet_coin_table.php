<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionBetCoinTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('option_bet_coin', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('coin_id')->unsigned()->comment('主键');
			$table->char('coin_name', 11)->default('')->comment('虚拟货币名称');
			$table->string('min_amount', 20)->nullable()->comment('最小购买量');
			$table->string('max_amount', 20)->nullable()->comment('最大购买量');
			$table->boolean('is_bet')->default(1)->comment('是否可期权交易');
			$table->integer('sort')->unsigned()->default(1)->comment('排序');
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
		Schema::drop('option_bet_coin');
	}
}
