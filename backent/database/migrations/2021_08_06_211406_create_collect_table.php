<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('collect', function (Blueprint $table) {
			$table->integer('id', true);
			$table->integer('user_id')->comment('用户id');
			$table->integer('pair_id')->nullable();
			$table->string('pair_name', 20)->comment('期权交易对名称');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('collect');
	}
}
