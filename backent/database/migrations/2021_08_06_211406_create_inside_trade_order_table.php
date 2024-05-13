<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsideTradeOrderTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inside_trade_order', function (Blueprint $table) {
			$table->increments('order_id')->comment('主键');
			$table->string('buy_order_no', 30)->comment('买单订单号');
			$table->string('sell_order_no', 30)->comment('卖单订单号');
			$table->integer('buy_id')->unsigned()->default(0)->comment('买单ID');
			$table->integer('sell_id')->unsigned()->default(0)->comment('卖单ID');
			$table->integer('buy_user_id')->unsigned()->default(0)->index('user_id')->comment('买家用户ID');
			$table->integer('sell_user_id')->unsigned()->default(0)->comment('卖家用户ID');
			$table->decimal('unit_price', 20, 8)->unsigned()->default(0.00000000)->comment('成交价格');
			$table->string('symbol', 30)->nullable()->comment('币对');
			$table->integer('quote_coin_id')->unsigned()->default(0)->comment('报价币种');
			$table->integer('base_coin_id')->unsigned()->default(0)->comment('交换的币种');
			$table->decimal('trade_amount', 20, 8)->unsigned()->default(0.00000000)->comment('交易数量');
			$table->decimal('trade_money', 20, 8)->unsigned()->default(0.00000000)->comment('交易额');
			$table->decimal('trade_buy_fee', 20, 8)->unsigned()->default(0.00000000)->comment('交易买手续费');
			$table->decimal('trade_sell_fee', 20, 8)->unsigned()->default(0.00000000)->comment('交易卖手续费');
			$table->boolean('status')->default(1)->comment('1代表已完成');
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
		Schema::drop('inside_trade_order');
	}
}
