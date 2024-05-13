<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusLogsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bonus_logs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0)->comment('用户ID');
			$table->integer('coin_id')->unsigned()->nullable()->default(0)->comment('币种ID');
			$table->string('coin_name', 30)->nullable()->comment('币种名称');
			$table->boolean('account_type')->nullable()->default(1)->comment('账户类型');
			$table->string('rich_type', 30)->nullable()->comment('资产类型');
			$table->decimal('amount', 12, 4)->unsigned()->nullable()->default(0.0000)->comment('数量');
			$table->string('log_type', 50)->nullable()->comment('日志类型');
			$table->boolean('status')->nullable()->default(1)->comment('状态 -1已关闭 1待发放 2已发放');
			$table->dateTime('hand_time')->nullable()->comment('发放时间');
			$table->integer('bonusable_id')->unsigned()->nullable()->default(0);
			$table->string('bonusable_type')->nullable();
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
		Schema::drop('bonus_logs');
	}
}
