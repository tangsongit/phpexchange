<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCategoryTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_category', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('pid')->unsigned()->nullable()->default(0);
			$table->integer('order')->unsigned()->nullable()->default(1);
			$table->timestamps();
			$table->softDeletes();
			$table->text('url')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('article_category');
	}
}
