<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCenterWalletTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('center_wallet', function (Blueprint $table) {
			$table->smallInteger('center_wallet_id', true)->unsigned();
			$table->string('center_wallet_name', 50)->nullable();
			$table->string('center_wallet_account', 80)->default('')->comment('中心钱包账户名');
			$table->string('center_wallet_address', 100)->default('')->comment('中心钱包地址');
			$table->string('center_wallet_password', 80)->default('');
			$table->decimal('center_wallet_balance', 25, 12)->unsigned()->default(0.000000000000)->comment('中央钱包余额');
			$table->integer('coin_id')->unsigned()->default(0)->comment('币种id');
			$table->decimal('min_amount', 12, 4)->nullable();
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
		Schema::drop('center_wallet');
	}
}
