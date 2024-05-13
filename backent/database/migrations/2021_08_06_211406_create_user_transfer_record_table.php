<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTransferRecordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_transfer_record', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->comment('用户ID');
			$table->integer('coin_id')->nullable()->comment('币种ID');
			$table->string('coin_name', 30)->comment('币种名称');
			$table->string('draw_out_direction', 30)->comment('划出地址');
			$table->string('into_direction', 30)->comment('划转方向');
			$table->string('amount', 30)->comment('划转数量');
			$table->integer('status')->comment('1代表成功,2代表失败');
			$table->integer('datetime')->comment('划转时间');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_transfer_record');
	}

}
