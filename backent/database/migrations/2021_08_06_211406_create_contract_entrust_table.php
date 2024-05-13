<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractEntrustTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_entrust', function (Blueprint $table) {
			$table->increments('id')->comment('主键');
			$table->string('order_no', 30)->default('0')->comment('订单号');
			$table->boolean('order_type')->default(1)->comment('交易类型 1开仓 2平仓');
			$table->integer('user_id')->unsigned()->default(0)->index('user_id')->comment('用户id');
			$table->boolean('side')->default(1)->index('side')->comment('买卖方向 1买入 2卖出');
			$table->integer('contract_id')->unsigned()->default(0)->index('contract_id')->comment('合约');
			$table->integer('contract_coin_id')->unsigned()->default(0)->comment('合约币种id');
			$table->string('symbol', 30)->comment('合约symbol');
			$table->integer('margin_coin_id')->unsigned()->default(1);
			$table->string('unit_amount', 30)->nullable();
			$table->boolean('type')->default(1)->comment('委托方式 1限价交易 2市价交易 3止盈止损');
			$table->decimal('entrust_price', 20, 8)->unsigned()->nullable()->comment('委托价格');
			$table->decimal('trigger_price', 20, 8)->unsigned()->nullable();
			$table->integer('amount')->unsigned()->default(0)->comment('委托张数');
			$table->integer('traded_amount')->unsigned()->nullable()->default(0)->comment('已成交张数');
			$table->decimal('avg_price', 20, 8)->unsigned()->nullable()->comment('成交均价');
			$table->decimal('profit', 20, 8)->nullable()->comment('盈亏');
			$table->string('settle_profit', 30)->nullable()->comment('实际结算盈亏');
			$table->boolean('is_wear')->nullable()->default(0)->comment('是否穿仓');
			$table->integer('lever_rate')->unsigned()->default(0)->comment('杠杆倍数');
			$table->decimal('margin', 20, 8)->nullable()->comment('委托保证金');
			$table->decimal('fee', 20, 8)->nullable()->comment('委托手续费');
			$table->boolean('status')->default(1)->comment('交易进度 0已撤单，1未成交，2部分成交，3全部成交');
			$table->boolean('hang_status')->nullable()->default(1);
			$table->integer('cancel_time')->unsigned()->nullable();
			$table->integer('ts')->unsigned()->default(0);
			$table->boolean('system')->nullable()->default(0);
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
		Schema::drop('contract_entrust');
	}
}
