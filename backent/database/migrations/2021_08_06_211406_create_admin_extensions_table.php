<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminExtensionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_extensions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 100)->unique();
			$table->string('version', 20)->default('');
			$table->boolean('is_enabled')->default(0);
			$table->text('options')->nullable();
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
		Schema::drop('admin_extensions');
	}
}
