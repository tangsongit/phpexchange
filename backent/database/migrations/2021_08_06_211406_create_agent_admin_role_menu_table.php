<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentAdminRoleMenuTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agent_admin_role_menu', function (Blueprint $table) {
			$table->bigInteger('role_id');
			$table->bigInteger('menu_id');
			$table->timestamps();
			$table->unique(['role_id', 'menu_id'], 'admin_role_menu_role_id_menu_id_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agent_admin_role_menu');
	}
}
