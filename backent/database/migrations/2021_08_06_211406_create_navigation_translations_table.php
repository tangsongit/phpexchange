<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('navigation_translations', function(Blueprint $table)
		{
			$table->smallInteger('id', true);
			$table->string('locale', 50);
			$table->string('name', 50)->nullable()->default('NULL');
			$table->integer('n_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('navigation_translations');
	}

}
