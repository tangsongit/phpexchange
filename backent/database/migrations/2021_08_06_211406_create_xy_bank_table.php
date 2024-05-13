<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXyBankTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('xy_bank', function(Blueprint $table)
		{
			$table->integer('id')->primary()->comment('xy_bank');
			$table->string('bank_name', 100)->nullable();
			$table->string('ispb', 50)->nullable();
			$table->string('code_number', 100)->nullable();
			$table->string('nome_extenso')->nullable();
			$table->dateTime('createtime')->nullable();
			$table->boolean('status')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('xy_bank');
	}

}
