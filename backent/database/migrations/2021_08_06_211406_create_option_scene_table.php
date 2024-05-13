<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionSceneTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('option_scene', function (Blueprint $table) {
			$table->bigInteger('scene_id', true)->unsigned();
			$table->string('scene_sn', 50)->comment('编号');
			$table->integer('time_id')->unsigned()->default(0)->index('time_id')->comment('期权场次id');
			$table->integer('seconds')->unsigned()->nullable();
			$table->integer('pair_id')->unsigned()->default(0)->index('pair_id')->comment('期权交易对id');
			$table->string('pair_time_name', 50)->nullable()->comment('期权场景名称');
			$table->text('up_odds')->nullable();
			$table->text('down_odds')->nullable();
			$table->text('draw_odds')->nullable();
			$table->integer('begin_time')->unsigned()->index('begin_time')->comment('开始时间');
			$table->integer('end_time')->unsigned()->index('end_time')->comment('结束时间');
			$table->decimal('begin_price', 12, 4)->unsigned()->nullable()->comment('开盘价');
			$table->decimal('end_price', 12, 4)->unsigned()->nullable()->comment('收盘价');
			$table->boolean('delivery_up_down')->nullable()->comment('涨幅结果：1涨 2跌 3平');
			$table->decimal('delivery_range', 12, 3)->unsigned()->nullable()->comment('幅度绝对值');
			$table->integer('delivery_time')->unsigned()->nullable()->comment('交割时间');
			$table->boolean('status')->default(1)->comment('1--待购买 2--购买中 3--交割中 4--已交割');
			$table->timestamps();
			$table->index(['time_id', 'pair_id'], 'time_pair');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('option_scene');
	}
}
