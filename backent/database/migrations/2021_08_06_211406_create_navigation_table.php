<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('navigation', function (Blueprint $table) {
			$table->increments('id');
			$table->boolean('type')->default(1)->comment('导航位置 1顶部 2服务 3 学院');
			$table->string('img', 100)->nullable()->comment('导航图片');
			$table->string('link_type', 191)->nullable()->comment('导航链接类型');
			$table->string('link_data', 300)->nullable()->comment('导航链接数据');
			$table->text('desc')->nullable()->comment('导航描述');
			$table->integer('order')->unsigned()->nullable()->default(1)->comment('排序');
			$table->boolean('status')->nullable()->default(1)->comment('是否显示在首页开关（0不显示1显示）');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('navigation');
	}
}
