<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractAccountTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_account', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0)->unique('user_id')->comment('用户ID');
			$table->integer('coin_id')->unsigned()->nullable()->comment('币种ID');
			$table->string('coin_name', 30)->nullable()->comment('币种名称');
			$table->string('margin_name', 30)->default('USDT')->comment('合约保证金币种');
			$table->decimal('usable_balance', 20, 8)->unsigned()->default(0.00000000)->comment('可用');
			$table->decimal('used_balance', 20, 8)->unsigned()->default(0.00000000)->comment('持仓保证金');
			$table->decimal('freeze_balance', 20, 8)->unsigned()->default(0.00000000)->comment('委托冻结');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contract_account');
	}

}
