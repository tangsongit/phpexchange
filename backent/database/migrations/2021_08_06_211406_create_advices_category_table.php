<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvicesCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('advices_category', function(Blueprint $table)
		{
			$table->smallInteger('id', true);
			$table->string('name', 60)->comment('反馈问题类型名称');
			$table->boolean('status')->nullable()->default(1)->comment('状态1:显示 0：隐藏');
			$table->integer('order')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('advices_category');
	}

}
