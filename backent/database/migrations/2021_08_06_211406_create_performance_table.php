<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('performance', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('aid')->unsigned()->nullable()->default(0)->comment('代理ID');
			$table->dateTime('start_time')->nullable()->comment('开始时间');
			$table->dateTime('end_time')->nullable()->comment('结束时间');
			$table->decimal('subscribe_performance', 20, 8)->nullable()->default(0.00000000)->comment('申购业绩');
			$table->decimal('contract_performance', 20, 8)->nullable()->default(0.00000000)->comment('合约业绩');
			$table->decimal('option_performance', 20, 8)->nullable()->default(0.00000000)->comment('期权业绩');
			$table->float('subscribe_rebate_rate', 10, 4)->nullable()->default(0.0000)->comment('申购返佣比率');
			$table->float('contract_rebate_rate', 10, 4)->nullable()->default(0.0000)->comment('合约返佣比率');
			$table->float('option_rebate_rate', 10, 4)->nullable()->default(0.0000)->comment('期权返佣比率');
			$table->decimal('subscribe_rebate', 20, 8)->nullable()->default(0.00000000)->comment('申购返佣');
			$table->decimal('contract_rebate', 20, 8)->nullable()->default(0.00000000)->comment('合约返佣');
			$table->decimal('option_rebate', 20, 8)->nullable()->default(0.00000000)->comment('期权返佣');
			$table->boolean('status')->nullable()->default(1)->comment('状态');
			$table->string('remark')->nullable();
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
		Schema::drop('performance');
	}
}
