<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractPairTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_pair', function (Blueprint $table) {
			$table->bigInteger('id', true);
			$table->string('symbol', 50)->nullable()->comment('合约symbol');
			$table->integer('contract_coin_id')->unique('symbol')->comment('合约币种ID');
			$table->string('contract_coin_name', 30)->comment('合约币种名称');
			$table->integer('margin_coin_id')->unsigned()->default(1);
			$table->string('type', 30)->comment('USDT保证金合约');
			$table->string('unit_amount', 30)->comment('合约单张面值（USDT）');
			$table->float('maker_fee_rate', 10, 5)->unsigned()->default(0.00050)->comment('Maker手续费率');
			$table->float('taker_fee_rate', 10, 5)->unsigned()->default(0.00050)->comment('Taker手续费率');
			$table->boolean('status')->default(1)->comment('状态');
			$table->boolean('trade_status')->default(1)->comment('交易状态');
			$table->text('lever_rage')->nullable()->comment('杠杆倍数');
			$table->string('default_lever', 30)->nullable()->comment('默认杠杠');
			$table->integer('min_qty')->unsigned()->default(1)->comment('单笔最小下单（张）');
			$table->integer('max_qty')->unsigned()->default(1000)->comment('单笔最大下单（张）');
			$table->integer('total_max_qty')->unsigned()->default(10000)->comment('最大持仓量（张）');
			$table->string('buy_spread', 30)->nullable();
			$table->string('sell_spread', 30)->nullable();
			$table->string('settle_spread', 30)->nullable();
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
		Schema::drop('contract_pair');
	}
}
