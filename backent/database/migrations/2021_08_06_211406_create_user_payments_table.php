<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPaymentsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_payments', function (Blueprint $table) {
			$table->integer('id', true)->comment('会员支付方式表');
			$table->integer('user_id')->comment('会员id');
			$table->string('pay_type', 50)->default('bank_card')->comment('bank_card银行卡，alipay支付宝，wechat微信');
			$table->string('bank_name', 100)->nullable()->comment('银行名称');
			$table->string('real_name', 50)->comment('持卡人姓名');
			$table->string('card_no', 50)->nullable()->comment('bank_card->卡号 wechat->账户名称  alipay->账户名称');
			$table->string('open_bank', 100)->nullable()->comment('开户支行');
			$table->string('code_img', 1000)->nullable()->comment('微信/支付宝 二维码');
			$table->boolean('status')->default(1)->comment('状态 0禁用 1开启');
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
		Schema::drop('user_payments');
	}
}
