<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractOrderTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_order', function (Blueprint $table) {
			$table->integer('id', true);
			$table->integer('contract_id')->unsigned()->default(0)->comment('合约代码取值范围BTC-USD');
			$table->string('symbol', 30);
			$table->string('unit_amount', 30)->nullable();
			$table->integer('lever_rate')->unsigned()->default(0)->comment('杠杆倍数');
			$table->boolean('order_type')->default(1);
			$table->integer('buy_id')->unsigned()->default(0)->comment('买单ID');
			$table->integer('sell_id')->unsigned()->default(0)->comment('卖单ID');
			$table->integer('buy_user_id')->unsigned()->default(0)->comment('买家用户ID');
			$table->integer('sell_user_id')->unsigned()->default(0)->comment('卖家用户ID');
			$table->decimal('unit_price', 20, 8)->unsigned()->default(0.00000000)->comment('成交价格');
			$table->integer('trade_amount')->unsigned()->default(0)->comment('交易数量');
			$table->decimal('trade_buy_fee', 20, 8)->unsigned()->nullable()->default(0.00000000)->comment('交易手续费');
			$table->decimal('trade_sell_fee', 20, 8)->unsigned()->nullable()->default(0.00000000);
			$table->boolean('status')->default(1)->comment('1代表已完成');
			$table->integer('ts')->unsigned()->default(0);
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
		Schema::drop('contract_order');
	}
}
