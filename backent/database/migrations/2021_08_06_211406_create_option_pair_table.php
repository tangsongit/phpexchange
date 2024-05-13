<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionPairTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('option_pair', function (Blueprint $table) {
			$table->bigInteger('pair_id', true)->unsigned();
			$table->string('pair_name', 50)->comment('交易对名称');
			$table->string('symbol', 30)->nullable();
			$table->integer('quote_coin_id');
			$table->string('quote_coin_name', 30);
			$table->integer('base_coin_id');
			$table->string('base_coin_name', 30);
			$table->boolean('status')->default(0);
			$table->boolean('trade_status')->nullable()->default(1);
			$table->integer('sort')->unsigned()->nullable()->default(0);
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
		Schema::drop('option_pair');
	}
}
