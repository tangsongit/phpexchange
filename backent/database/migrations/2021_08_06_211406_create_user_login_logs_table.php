<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoginLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_login_logs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable()->default(0)->comment('用户User_id');
			$table->string('username')->nullable()->comment('登录用户名字');
			$table->integer('login_time')->unsigned()->nullable()->default(0)->comment('登录时间');
			$table->string('login_ip', 16)->nullable()->comment('登录IP地址');
			$table->string('login_site')->nullable()->comment('登陆地点');
			$table->string('login_type')->nullable()->comment('登录类型');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_login_logs');
	}

}
