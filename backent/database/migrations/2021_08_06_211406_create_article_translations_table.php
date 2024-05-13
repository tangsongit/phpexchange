<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-06 21:14:07
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-06 22:06:22
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTranslationsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_translations', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('article_id')->unsigned()->nullable();
			$table->string('locale', 30)->nullable();
			$table->string('title')->nullable();
			$table->longtext('body')->nullable();
			$table->text('excerpt')->nullable();
			$table->unique(['article_id', 'locale'], 'locale_insurance');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('article_translations');
	}
}
