<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscribeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_subscribe', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('coin_name', 30)->default('0')->comment('币种英文名');
			$table->string('issue_price', 30)->default('0')->comment('发行价');
			$table->string('subscribe_currency', 50)->default('0')->comment('申购币种');
			$table->dateTime('expected_time_online')->nullable()->comment('预计上线时间');
			$table->dateTime('start_subscription_time')->nullable()->comment('开始申购时间');
			$table->dateTime('end_subscription_time')->nullable()->comment('结束申购时间');
			$table->dateTime('announce_time')->nullable()->comment('公布结果时间');
			$table->integer('status')->nullable()->default(1)->comment('1 代表预热  2 开始申购 3结束申购 4 公布结果');
			$table->string('project_details', 500)->nullable()->comment('项目详情');
			$table->string('en_project_details', 800)->nullable()->comment('英文项目详情');
			$table->integer('maximum_purchase')->nullable()->comment('最大申购');
			$table->integer('minimum_purchase')->nullable()->comment('最少申购');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_subscribe');
	}

}
