<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataBtTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data_bt', function(Blueprint $table)
		{
			$table->increments('id')->comment('id');
			$table->integer('pid');
			$table->string('Symbol', 28)->comment('产品代码');
			$table->integer('Date')->default(0)->index('Date')->comment('时间戳');
			$table->dateTime('datetime')->nullable();
			$table->string('Name', 88)->default('')->comment('产品名称');
			$table->float('Open', 18, 5)->default(0.00000)->comment('开盘价');
			$table->float('High', 18, 5)->default(0.00000)->comment('最高价');
			$table->float('Low', 18, 5)->default(0.00000)->comment('最低价');
			$table->float('Close', 18, 5)->default(0.00000)->comment('最新价');
			$table->float('LastClose', 18, 5)->nullable()->default(0.00000)->comment('昨收价（日线）');
			$table->float('Price2', 18, 5)->nullable()->default(0.00000)->comment('期货当日结算价（盘中为0，收盘后交易所才提供）（日线）');
			$table->float('Price3', 18, 5)->nullable()->default(0.00000)->comment('股票为成交总笔数，期货是前一交易日结算价（日线）');
			$table->float('Open_Int', 18, 5)->nullable()->default(0.00000)->comment('仅期货有效，持仓（未平仓合约）');
			$table->float('Volume', 18, 5)->nullable()->default(0.00000)->comment('成交量');
			$table->float('Amount', 18, 5)->nullable()->default(0.00000)->comment('成交额');
			$table->boolean('is_1min')->nullable()->default(0);
			$table->boolean('is_5min')->nullable()->default(0)->comment('是否是5分钟线');
			$table->boolean('is_15min')->nullable()->default(0);
			$table->boolean('is_30min')->nullable()->default(0);
			$table->boolean('is_1h')->nullable()->default(0);
			$table->boolean('is_2h')->nullable()->default(0);
			$table->boolean('is_4h')->nullable()->default(0);
			$table->boolean('is_6h')->nullable()->default(0);
			$table->boolean('is_12h')->nullable()->default(0);
			$table->boolean('is_day')->nullable()->default(0);
			$table->boolean('is_week')->nullable()->default(0);
			$table->integer('is_month')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('data_bt');
	}

}
