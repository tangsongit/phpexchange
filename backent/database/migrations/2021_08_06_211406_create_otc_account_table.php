<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtcAccountTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('otc_account', function (Blueprint $table) {
			$table->increments('id')->comment('主键');
			$table->integer('user_id')->unsigned()->default(0)->index('user_id')->comment('用户id');
			$table->integer('coin_id')->unsigned()->default(0)->index('coin_id')->comment('币种id');
			$table->string('coin_name', 30)->comment('币种名称');
			$table->decimal('usable_balance', 20, 8)->unsigned()->default(0.00000000)->comment('可用余额');
			$table->decimal('freeze_balance', 20, 8)->unsigned()->default(0.00000000)->comment('冻结余额');
			$table->timestamps();
			$table->unique(['user_id', 'coin_id'], 'user_coin');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('otc_account');
	}
}
