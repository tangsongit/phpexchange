<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banner', function (Blueprint $table) {
			$table->increments('id')->comment('主键');
			$table->boolean('location_type')->default(1)->comment('1:轮播图 2:LOGO');
			$table->string('tourl')->nullable()->default('')->comment('跳转数据');
			$table->boolean('tourl_type')->nullable()->default(0)->comment('跳转类型 0不跳转 1跳APP页面');
			$table->boolean('status')->nullable()->default(1)->comment('是否显示 1显示0不显示');
			$table->integer('order')->unsigned()->nullable()->default(0)->comment('排序');
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
		Schema::drop('banner');
	}
}
