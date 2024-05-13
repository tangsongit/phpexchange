<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionTimeTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('option_time', function (Blueprint $table) {
			$table->bigInteger('time_id', true)->unsigned();
			$table->string('time_name', 50)->comment('场次名称');
			$table->integer('seconds')->unsigned()->default(0);
			$table->decimal('fee_rate', 10, 4)->unsigned()->nullable()->default(0.0000);
			$table->text('odds_up_range')->nullable();
			$table->text('odds_down_range')->nullable();
			$table->text('odds_draw_range')->nullable();
			$table->boolean('status')->default(0);
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
		Schema::drop('option_time');
	}
}
