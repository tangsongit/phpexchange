<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtcAppealTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('otc_appeal', function (Blueprint $table) {
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('order_id')->comment('订单ID');
			$table->bigInteger('user_id')->comment('用户ID');
			$table->string('describe')->comment('描述');
			$table->string('image')->comment('照片');
			$table->boolean('status')->default(1)->comment('0 已删除 1已经提交 2已解决 3解决失败');
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
		Schema::drop('otc_appeal');
	}
}
