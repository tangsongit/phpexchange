<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentAdminPermissionMenuTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agent_admin_permission_menu', function (Blueprint $table) {
			$table->bigInteger('permission_id');
			$table->bigInteger('menu_id');
			$table->timestamps();
			$table->unique(['permission_id', 'menu_id'], 'admin_permission_menu_permission_id_menu_id_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agent_admin_permission_menu');
	}
}
