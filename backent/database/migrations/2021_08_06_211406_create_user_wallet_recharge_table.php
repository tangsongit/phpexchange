<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletRechargeTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_wallet_recharge', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0)->comment('会员ID');
			$table->string('username', 50)->comment('用户名称');
			$table->integer('coin_id');
			$table->string('coin_name', 20)->comment('币名');
			$table->integer('datetime')->comment('日期');
			$table->string('amount', 30)->comment('数量');
			$table->string('status', 50)->nullable()->default('0')->comment('0待审核 1通过 2拒绝');
			$table->text('remark')->nullable()->comment('审核备注');
			$table->integer('check_time')->unsigned()->nullable()->comment('审核时间');
			$table->string('address', 100)->nullable()->comment('充值地址');
			$table->string('txid', 120)->nullable()->comment('交易hash');
			$table->boolean('type')->nullable()->default(1)->comment('1-在线 2-后台');
			$table->boolean('account_type')->nullable()->default(1);
			$table->string('note', 100)->nullable()->comment('备注');
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
		Schema::drop('user_wallet_recharge');
	}
}
