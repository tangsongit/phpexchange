<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentAdminUsersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agent_admin_users', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned();
			$table->string('username', 120)->unique('admin_users_username_unique');
			$table->string('password', 80);
			$table->string('name');
			$table->integer('user_id');
			$table->string('avatar')->nullable();
			$table->integer('pid');
			$table->string('remember_token', 100)->nullable();
			$table->integer('invite_code')->nullable()->comment('邀请码 5级代理才能拥有');
			$table->integer('deep');
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
		Schema::drop('agent_admin_users');
	}
}
