<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractShareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_share', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('bg_img', 100)->nullable()->comment('杠杆倍数');
			$table->string('text_img', 100)->nullable();
			$table->string('peri_img', 100)->nullable();
			$table->boolean('status')->nullable()->default(1);
			$table->integer('created_at')->nullable();
			$table->integer('updated_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contract_share');
	}

}
