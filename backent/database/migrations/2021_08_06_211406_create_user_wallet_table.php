<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_wallet', function (Blueprint $table) {
			$table->increments('wallet_id')->comment('主键');
			$table->integer('user_id')->unsigned()->default(0)->index('user_id')->comment('用户id');
			$table->integer('coin_id')->unsigned()->default(0)->index('coin_id')->comment('虚拟货币钱包类型id');
			$table->string('coin_name', 30)->comment('币种名称');
			$table->string('omni_wallet_address', 100)->nullable()->default('')->comment('钱包地址');
			$table->string('trx_wallet_address', 100)->nullable();
			$table->string('wallet_address', 100)->nullable()->default('')->index('address')->comment('钱包地址');
			$table->text('raw_data')->nullable()->comment('地址原始数据（存储公钥私钥密码等数据）');
			$table->decimal('usable_balance', 20, 8)->unsigned()->default(0.00000000)->comment('可用余额');
			$table->decimal('freeze_balance', 20, 8)->default(0.00000000)->comment('冻结余额');
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
		Schema::drop('user_wallet');
	}
}
