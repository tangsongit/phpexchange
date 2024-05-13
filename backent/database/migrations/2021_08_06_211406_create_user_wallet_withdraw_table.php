<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletWithdrawTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_wallet_withdraw', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0);
			$table->string('username', 50)->comment('用户名称');
			$table->string('address', 50)->comment('提币地址');
			$table->boolean('address_type')->nullable()->comment('地址类型');
			$table->string('total_amount', 30)->comment('提币数量');
			$table->string('amount', 30)->comment('实际到账数量');
			$table->string('withdrawal_fee', 30)->comment('手续费');
			$table->boolean('status')->default(0)->comment('0待审核 1通过 2拒绝');
			$table->text('remark')->nullable()->comment('审核备注');
			$table->integer('check_time')->nullable()->comment('审核时间');
			$table->integer('coin_id')->comment('币种ID');
			$table->string('coin_name', 30)->nullable();
			$table->string('address_note', 100)->nullable()->comment('钱包地址备注比如交易所 或者是什么钱包的地址');
			$table->integer('datetime')->comment('日期');
			$table->string('hash')->nullable();
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
		Schema::drop('user_wallet_withdraw');
	}
}
