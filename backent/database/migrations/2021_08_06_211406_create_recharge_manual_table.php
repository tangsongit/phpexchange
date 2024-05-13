<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRechargeManualTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recharge_manual', function (Blueprint $table) {
			$table->integer('id', true)->comment('ID');
			$table->integer('uid')->comment('用户ID');
			$table->char('account')->comment('账号');
			$table->decimal('num', 10)->comment('充值数量');
			$table->char('image')->comment('图片凭证');
			$table->integer('status')->comment('状态;0=审核中,1=成功,2=驳回');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recharge_manual');
	}
}
