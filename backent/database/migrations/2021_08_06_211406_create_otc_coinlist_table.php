<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtcCoinlistTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('otc_coinlist', function (Blueprint $table) {
			$table->integer('id', true);
			$table->integer('coin_id')->unique('coin_id')->comment('币种ID');
			$table->string('coin_name')->index('coin_name')->comment('币种名称');
			$table->decimal('limit_amount', 8, 4)->default(0.1000)->comment('最低发布数量');
			$table->string('max_register_time', 30)->default('72')->comment('最大挂单时间(按小时计算)');
			$table->string('max_register_num', 30)->default('1')->comment('最大挂单数');
			$table->boolean('status')->default(0)->index('status')->comment('status 0禁用 1启用');
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
		Schema::drop('otc_coinlist');
	}
}
