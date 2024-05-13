<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppVersionTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('app_version', function (Blueprint $table) {
			$table->increments('id');
			$table->boolean('client_type')->default(1)->comment('1安卓2苹果');
			$table->char('version', 20)->default('')->comment('版本号');
			$table->boolean('is_must')->default(1)->comment('是否必须升级1是0否');
			$table->string('update_log', 1000)->nullable()->default('')->comment('升级说明');
			$table->string('url')->nullable()->default('')->comment('地址');
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
		Schema::drop('app_version');
	}
}
