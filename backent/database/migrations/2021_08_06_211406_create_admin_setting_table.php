<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminSettingTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_setting', function (Blueprint $table) {
			$table->increments('id');
			$table->string('module', 30)->default('common')->comment('模块：common - 通用');
			$table->string('title', 50);
			$table->string('key', 50);
			$table->text('value')->nullable();
			$table->string('type', 30)->default('text')->comment('显示类型：text,radio,checkbox,image');
			$table->string('tips')->nullable();
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
		Schema::drop('admin_setting');
	}
}
