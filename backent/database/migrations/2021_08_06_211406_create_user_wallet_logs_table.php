<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletLogsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_wallet_logs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0);
			$table->integer('s_user_id')->unsigned()->nullable()->default(0)->comment('下级id');
			$table->boolean('account_type')->default(1)->comment('账户类型(1账户资产 2合约账户)');
			$table->integer('sub_account')->nullable()->comment('子账户');
			$table->integer('coin_id')->unsigned()->default(0)->comment('币种ID');
			$table->string('coin_name', 30)->nullable();
			$table->string('rich_type', 30)->comment('资产类型');
			$table->decimal('amount', 20, 8)->default(0.00000000)->comment('金额');
			$table->string('log_type', 30)->comment('流水类型');
			$table->string('log_note', 30)->nullable()->comment('流水描述');
			$table->decimal('before_balance', 20, 8)->unsigned()->default(0.00000000)->comment('变更前余额');
			$table->decimal('after_balance', 20, 8)->unsigned()->default(0.00000000)->comment('变更后余额');
			$table->integer('logable_id')->nullable();
			$table->string('logable_type', 100)->nullable();
			$table->integer('ts')->nullable();
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
		Schema::drop('user_wallet_logs');
	}
}
