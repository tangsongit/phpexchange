<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsideTradeBuyTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inside_trade_buy', function (Blueprint $table) {
			$table->increments('id')->comment('主键');
			$table->string('order_no', 30)->default('0')->index('trade_order')->comment('订单号');
			$table->integer('user_id')->unsigned()->default(0)->index('user_id')->comment('用户id');
			$table->boolean('entrust_type')->default(1);
			$table->string('symbol', 30)->nullable()->comment('币对');
			$table->boolean('type')->comment('委托方式 1限价交易 2市价交易 3止盈止损');
			$table->decimal('entrust_price', 20, 8)->unsigned()->nullable()->default(0.00000000)->index('unit_price')->comment('委托价格');
			$table->decimal('trigger_price', 20, 8)->unsigned()->nullable()->comment('触发价');
			$table->integer('quote_coin_id')->unsigned()->default(0)->index('base_coin_id')->comment('基础币种');
			$table->integer('base_coin_id')->unsigned()->default(0)->index('exchange_coin_id')->comment('买入的币种');
			$table->decimal('amount', 20, 8)->unsigned()->nullable()->default(0.00000000)->comment('委托数量');
			$table->decimal('traded_amount', 20, 8)->unsigned()->default(0.00000000)->comment('已成交数量');
			$table->decimal('money', 20, 8)->unsigned()->nullable()->default(0.00000000)->comment('预期交易额');
			$table->decimal('traded_money', 20, 8)->unsigned()->nullable()->default(0.00000000)->comment('已成交额');
			$table->boolean('status')->default(1)->index('status')->comment('交易进度 0已撤单，1未成交，2部分成交，3全部成交');
			$table->integer('cancel_time')->nullable()->comment('撤单时间');
			$table->boolean('hang_status')->nullable()->default(1)->comment('挂单状态 0未挂单 1已挂单');
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
		Schema::drop('inside_trade_buy');
	}
}
