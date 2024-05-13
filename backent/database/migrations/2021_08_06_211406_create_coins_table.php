<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coins', function (Blueprint $table) {
			$table->increments('coin_id')->comment('主键');
			$table->string('coin_name', 20)->default('')->unique('coin_name')->comment('虚拟货币名称');
			$table->string('symbol', 30)->nullable();
			$table->integer('qty_decimals');
			$table->integer('price_decimals');
			$table->text('full_name');
			$table->string('withdrawal_fee', 30)->nullable()->default('0');
			$table->string('withdrawal_min', 30)->nullable()->default('0');
			$table->string('withdrawal_max', 30)->nullable()->default('0');
			$table->string('coin_withdraw_message')->nullable()->default('')->comment('提币时的注意事项');
			$table->string('coin_recharge_message')->nullable()->default('')->comment('充值时的注意事项');
			$table->string('coin_transfer_message')->nullable()->default('')->comment('划转时的注意事项');
			$table->text('coin_content')->nullable();
			$table->string('coin_icon')->nullable();
			$table->boolean('status')->nullable()->default(1);
			$table->string('appKey')->nullable();
			$table->string('appSecret')->nullable();
			$table->string('official_website_link', 100)->nullable()->comment('官网链接');
			$table->string('white_paper_link', 100)->nullable()->comment('白皮书链接');
			$table->string('block_query_link', 100)->nullable()->comment('区块查询链接');
			$table->dateTime('publish_time')->nullable()->comment('发行时间');
			$table->bigInteger('total_issuance')->nullable()->comment('发行总量');
			$table->bigInteger('total_circulation')->nullable()->comment('流通总量');
			$table->string('crowdfunding_price', 100)->nullable();
			$table->integer('order')->unsigned()->nullable()->default(1);
			$table->boolean('is_withdraw')->nullable()->default(0)->comment('区块提币');
			$table->boolean('is_recharge')->nullable()->default(0)->comment('区块充值');
			$table->boolean('can_recharge')->nullable()->default(0)->comment('可后台充值');
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
		Schema::drop('coins');
	}
}
