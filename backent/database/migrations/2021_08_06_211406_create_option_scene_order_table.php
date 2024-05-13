<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionSceneOrderTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('option_scene_order', function (Blueprint $table) {
			$table->bigInteger('order_id', true)->unsigned();
			$table->string('order_no', 30)->nullable();
			$table->bigInteger('scene_id')->unsigned()->comment('场景ID');
			$table->integer('pair_id')->nullable();
			$table->integer('time_id')->nullable();
			$table->string('pair_name', 30)->nullable();
			$table->string('time_name', 30)->nullable();
			$table->integer('user_id')->unsigned()->comment('用户ID');
			$table->decimal('bet_amount', 12, 4)->unsigned()->default(0.0000)->comment('购买数量');
			$table->integer('bet_coin_id')->unsigned()->default(0)->comment('币种ID');
			$table->string('bet_coin_name', 30)->comment('币种名称');
			$table->string('odds_uuid', 100)->comment('赔率ID');
			$table->decimal('odds')->unsigned()->comment('赔率（收益率）');
			$table->decimal('range', 12, 3)->unsigned()->comment('幅度绝对值（涨幅 跌幅）');
			$table->boolean('up_down')->comment('1涨 2跌 3平');
			$table->boolean('status')->default(1)->comment('状态 1待交割 2已交割');
			$table->decimal('fee', 10, 4)->nullable()->comment('手续费');
			$table->integer('delivery_time')->nullable()->comment('交割时间');
			$table->decimal('delivery_amount', 20, 4)->nullable();
			$table->integer('begin_time')->unsigned()->nullable();
			$table->integer('end_time')->unsigned()->nullable();
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
		Schema::drop('option_scene_order');
	}
}
