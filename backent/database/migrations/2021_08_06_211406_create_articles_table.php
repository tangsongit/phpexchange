<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('admin_user_id')->unsigned()->nullable()->default(1)->index('articles_user_id_index')->comment('文章作者');
			$table->integer('category_id')->unsigned()->index()->comment('文章分类');
			$table->integer('view_count')->unsigned()->default(0)->comment('查看数');
			$table->string('cover')->nullable()->comment('缩略图');
			$table->boolean('status')->default(1)->comment('是否显示');
			$table->integer('order')->unsigned()->default(0)->comment('排序');
			$table->timestamps();
			$table->softDeletes();
			$table->boolean('is_recommend')->nullable()->default(0)->comment('是否推荐 1:推荐 0:不推荐');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('articles');
	}
}
