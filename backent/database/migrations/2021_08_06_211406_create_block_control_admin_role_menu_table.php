<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockControlAdminRoleMenuTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('block_control_admin_role_menu', function (Blueprint $table) {
			$table->bigInteger('role_id');
			$table->bigInteger('menu_id');
			$table->timestamps();
			$table->unique(['role_id', 'menu_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('block_control_admin_role_menu');
	}
}
