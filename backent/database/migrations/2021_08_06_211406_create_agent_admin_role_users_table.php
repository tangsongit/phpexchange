<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentAdminRoleUsersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agent_admin_role_users', function (Blueprint $table) {
			$table->bigInteger('role_id');
			$table->bigInteger('user_id');
			$table->timestamps();
			$table->unique(['role_id', 'user_id'], 'admin_role_users_role_id_user_id_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agent_admin_role_users');
	}
}
