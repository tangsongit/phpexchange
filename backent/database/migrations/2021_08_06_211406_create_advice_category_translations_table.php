<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdviceCategoryTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('advice_category_translations', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('locale', 30)->nullable();
			$table->smallInteger('category_id')->nullable();
			$table->string('name', 80)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('advice_category_translations');
	}

}
