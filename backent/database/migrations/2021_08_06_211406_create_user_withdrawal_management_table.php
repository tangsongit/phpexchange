<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWithdrawalManagementTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_withdrawal_management', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0);
			$table->string('coin_name', 50)->comment('用户名称');
			$table->string('address_note', 100)->nullable()->comment('钱包地址备注比如交易所 或者是什么钱包的地址');
			$table->string('address', 50)->comment('提币地址');
			$table->integer('datetime');
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
		Schema::drop('user_withdrawal_management');
	}
}
