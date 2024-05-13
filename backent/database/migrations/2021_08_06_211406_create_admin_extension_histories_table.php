<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminExtensionHistoriesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_extension_histories', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned();
			$table->string('name', 100)->index();
			$table->boolean('type')->default(1);
			$table->string('version', 20)->default('0');
			$table->text('detail')->nullable();
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
		Schema::drop('admin_extension_histories');
	}
}
