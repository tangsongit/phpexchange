<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractStrategyTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_strategy', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0)->comment('用户ID');
			$table->integer('contract_id')->unsigned()->index('contract_id');
			$table->string('symbol', 30)->index('symbol');
			$table->boolean('position_side')->index('position_side')->comment('仓位方向 1多仓 2空仓');
			$table->decimal('current_price', 10)->unsigned()->comment('当前价');
			$table->decimal('sl_price', 20, 8)->unsigned()->nullable()->comment('止损委托价');
			$table->decimal('sl_trigger_price', 20, 8)->unsigned()->nullable()->comment('止损触发价');
			$table->boolean('sl_trigger_type')->nullable()->comment('止损委托类型 1限价 2市价');
			$table->decimal('tp_price', 20, 8)->unsigned()->nullable()->comment('止盈委托价');
			$table->decimal('tp_trigger_price', 20, 8)->unsigned()->nullable()->comment('止盈触发价');
			$table->boolean('tp_trigger_type')->nullable()->comment('止盈委托类型 1限价 2市价');
			$table->boolean('status')->default(1);
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
		Schema::drop('contract_strategy');
	}
}
