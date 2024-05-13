<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsideTradePairTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inside_trade_pair', function (Blueprint $table) {
			$table->bigInteger('pair_id', true)->unsigned();
			$table->string('pair_name', 30)->comment('交易对名称');
			$table->string('symbol', 30)->nullable()->unique('symbol');
			$table->integer('quote_coin_id');
			$table->string('quote_coin_name', 30);
			$table->integer('base_coin_id');
			$table->string('base_coin_name', 30);
			$table->integer('qty_decimals')->unsigned()->default(2);
			$table->integer('price_decimals')->unsigned()->default(2);
			$table->decimal('min_qty', 12, 4)->nullable();
			$table->decimal('min_total', 12, 4)->nullable();
			$table->decimal('trigger_price_buy_rate', 4)->unsigned()->nullable()->default(1.10)->comment('3止盈止损委托 买入触发价设定限制比率');
			$table->decimal('trigger_price_sell_rate', 4)->unsigned()->nullable()->default(0.90)->comment('3止盈止损委托 卖出触发价设定限制比率');
			$table->integer('sort')->unsigned()->nullable()->default(255);
			$table->boolean('status')->default(0)->comment('0下线 1上线');
			$table->boolean('trade_status')->nullable()->default(1);
			$table->boolean('is_market')->nullable()->default(1);
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
		Schema::drop('inside_trade_pair');
	}
}
