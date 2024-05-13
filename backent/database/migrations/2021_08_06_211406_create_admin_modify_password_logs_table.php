<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminModifyPasswordLogsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_modify_password_logs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable()->default(0)->comment('用户User_id');
			$table->string('username')->nullable()->comment('用户名');
			$table->string('user_password_hash', 80)->nullable();
			$table->string('new_password', 80)->nullable();
			$table->integer('operation_time')->unsigned()->nullable()->default(0)->comment('操作时间');
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
		Schema::drop('admin_modify_password_logs');
	}
}
