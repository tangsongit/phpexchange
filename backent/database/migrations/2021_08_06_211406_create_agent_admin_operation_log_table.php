<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentAdminOperationLogTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agent_admin_operation_log', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('user_id')->index('admin_operation_log_user_id_index');
			$table->string('path');
			$table->string('method', 10);
			$table->string('ip');
			$table->text('input');
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
		Schema::drop('agent_admin_operation_log');
	}
}
