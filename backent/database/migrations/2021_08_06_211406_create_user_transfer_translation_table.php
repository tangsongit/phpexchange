<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTransferTranslationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_transfer_translation', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('en_direction_out', 50)->nullable()->comment('转出');
			$table->string('en_direction_in', 50)->nullable()->comment('转入');
			$table->string('tw_direction_out', 50)->nullable()->comment('台湾字体转出方向');
			$table->string('tw_direction_in', 50)->nullable()->comment('台湾字体转入方向');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_transfer_translation');
	}

}
