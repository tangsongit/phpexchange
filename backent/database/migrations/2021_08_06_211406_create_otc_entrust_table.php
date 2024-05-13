<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtcEntrustTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('otc_entrust', function (Blueprint $table) {
			$table->integer('id', true);
			$table->integer('user_id')->index('user_id')->comment('用户ID');
			$table->integer('side')->default(0)->index('side')->comment('1买 2卖');
			$table->string('order_sn', 50)->comment('广告单号');
			$table->integer('coin_id')->index('coin_id')->comment('币种ID');
			$table->string('coin_name', 30)->index('coin_name')->comment('币种名字');
			$table->decimal('min_num', 20, 6)->nullable()->comment('最小限额');
			$table->decimal('max_num', 20, 6)->nullable()->comment('最大限额');
			$table->text('note')->nullable()->comment('备注');
			$table->string('pay_type', 100)->nullable()->comment('付款方式');
			$table->integer('publish_time')->unsigned()->comment('发布时间');
			$table->decimal('price', 20, 6)->unsigned()->comment('价格');
			$table->decimal('amount', 20, 6)->unsigned()->default(0.000000)->comment('数量');
			$table->decimal('cur_amount', 20, 6)->unsigned()->default(0.000000);
			$table->decimal('lock_amount', 20, 6)->unsigned()->default(0.000000)->comment('已成交数量');
			$table->integer('order_count')->unsigned()->default(0)->comment('下单次数');
			$table->integer('deal_count')->unsigned()->default(0)->index('deal_count')->comment('成交次数');
			$table->decimal('deal_rate', 4)->unsigned()->nullable()->default(0.00)->comment('成交率');
			$table->boolean('status')->default(1)->index('status')->comment('状态 1正常 0撤销 2已完成');
			$table->timestamps();
			$table->dateTime('overed_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('otc_entrust');
	}
}
