<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtcOrderTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('otc_order', function (Blueprint $table) {
			$table->integer('id', true);
			$table->boolean('trans_type')->index('trans_type')->comment('1买 2卖');
			$table->string('order_sn', 50)->comment('订单单号');
			$table->integer('user_id')->unsigned()->index('user_id')->comment('UID');
			$table->integer('other_uid')->unsigned()->comment('对方UID');
			$table->integer('entrust_id')->unsigned()->comment('委托ID');
			$table->integer('coin_id')->index('coin_id')->comment('币种ID');
			$table->string('coin_name', 30)->index('coin_name')->comment('币种名称');
			$table->float('amount', 9)->comment('数量');
			$table->string('pay_type', 30)->nullable();
			$table->float('price', 9)->nullable()->comment('单价');
			$table->string('money', 30)->nullable();
			$table->integer('order_time')->unsigned()->nullable()->comment('下单时间');
			$table->integer('pay_time')->unsigned()->nullable()->comment('支付时间');
			$table->integer('deal_time')->unsigned()->nullable()->comment('成交时间');
			$table->boolean('status')->nullable()->default(1)->index('status')->comment('0已取消 1待支付 2已支付待确认 3已完成 4申诉中');
			$table->boolean('appeal_status')->nullable()->comment('申诉状态 1待处理 2处理中 3处理完成');
			$table->integer('appeal_time')->nullable();
			$table->string('paid_img', 100)->nullable()->comment('支付凭证图片');
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
		Schema::drop('otc_order');
	}
}
