<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentAdminRolePermissionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agent_admin_role_permissions', function (Blueprint $table) {
			$table->bigInteger('role_id');
			$table->bigInteger('permission_id');
			$table->timestamps();
			$table->unique(['role_id', 'permission_id'], 'admin_role_permissions_role_id_permission_id_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agent_admin_role_permissions');
	}
}
