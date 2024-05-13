<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractPositionTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_position', function (Blueprint $table) {
			$table->integer('id', true);
			$table->integer('user_id')->unsigned()->default(0)->comment('用户ID');
			$table->boolean('side')->default(1)->comment('方向 1多头仓位 2空头仓位');
			$table->integer('contract_id')->unsigned()->default(0)->comment('合约ID');
			$table->string('symbol', 30)->nullable()->index('symbol');
			$table->string('unit_amount', 30)->nullable();
			$table->integer('contract_coin_id')->nullable();
			$table->integer('margin_coin_id')->nullable();
			$table->boolean('margin_mode')->nullable()->default(1)->comment('仓位模式：默认1全仓 2逐仓');
			$table->string('lever_rate', 20)->nullable()->comment('杠杆倍数');
			$table->decimal('liquidation_price', 20, 8)->unsigned()->nullable()->comment('预估强平价');
			$table->integer('hold_position')->unsigned()->nullable()->default(0)->comment('持仓数量');
			$table->integer('avail_position')->unsigned()->nullable()->default(0)->comment('可平数量');
			$table->integer('freeze_position')->unsigned()->nullable()->default(0)->comment('冻结数量');
			$table->decimal('position_margin', 20, 8)->unsigned()->nullable()->default(0.00000000)->comment('保证金');
			$table->decimal('fee', 12, 5)->nullable()->default(0.00000)->comment('手续费');
			$table->decimal('avg_price', 20, 8)->unsigned()->nullable()->default(0.00000000)->comment('开仓平均价');
			$table->decimal('settlement_price', 20, 8)->unsigned()->nullable()->default(0.00000000)->comment('结算基准价');
			$table->string('maintain_margin_rate', 30)->nullable()->comment('维持保证金率');
			$table->decimal('settled_pnl', 20, 8)->nullable()->comment('已结算收益');
			$table->decimal('realized_pnl', 20, 8)->nullable()->comment('已实现盈亏');
			$table->decimal('unrealized_pnl', 20, 8)->nullable()->default(0.00000000)->comment('未实现盈亏');
			$table->timestamps();
			$table->unique(['user_id', 'side', 'contract_id'], 'user_contract_side');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contract_position');
	}
}
