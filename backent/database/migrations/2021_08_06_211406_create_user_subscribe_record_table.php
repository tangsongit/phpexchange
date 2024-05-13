<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscribeRecordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_subscribe_record', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->comment('用户ID');
			$table->decimal('payment_amount', 25, 4)->comment('认购付款的币种数量');
			$table->string('payment_currency', 20)->comment('支付的币种');
			$table->integer('subscription_time')->comment('申购时间');
			$table->string('subscription_currency_name', 20)->comment('申购的币种名称');
			$table->decimal('subscription_currency_amount', 25)->comment('申购的币种数量');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_subscribe_record');
	}

}
