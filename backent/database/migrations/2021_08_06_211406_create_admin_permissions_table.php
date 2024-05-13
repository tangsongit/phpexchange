<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPermissionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_permissions', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned();
			$table->string('name', 50);
			$table->string('slug', 50)->unique();
			$table->string('http_method')->nullable();
			$table->text('http_path')->nullable();
			$table->integer('order')->default(0);
			$table->bigInteger('parent_id')->default(0);
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
		Schema::drop('admin_permissions');
	}
}
