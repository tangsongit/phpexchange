<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvicesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('advices', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->nullable();
			$table->string('phone', 30)->nullable();
			$table->string('email', 50)->nullable();
			$table->string('realname', 50);
			$table->text('contents');
			$table->text('imgs')->nullable();
			$table->boolean('is_process')->default(0)->comment('是否处理（默认0未处理 1已处理）');
			$table->string('process_note')->nullable()->comment('处理备注');
			$table->dateTime('process_time')->nullable()->comment('处理时间');
			$table->timestamps();
			$table->smallInteger('category_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('advices');
	}
}
