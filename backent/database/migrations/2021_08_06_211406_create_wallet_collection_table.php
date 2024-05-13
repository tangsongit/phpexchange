<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletCollectionTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wallet_collection', function (Blueprint $table) {
			$table->increments('id');
			$table->string('symbol', 30)->nullable()->comment('symbol');
			$table->string('from', 100)->nullable()->comment('from');
			$table->string('amount', 30)->nullable()->comment('数量');
			$table->string('to', 100)->nullable()->comment('to');
			$table->string('txid', 120)->nullable()->comment('交易hash');
			$table->integer('datetime')->nullable()->comment('日期');
			$table->string('note', 100)->nullable()->comment('备注');
			$table->boolean('status')->nullable()->default(0);
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
		Schema::drop('wallet_collection');
	}
}
