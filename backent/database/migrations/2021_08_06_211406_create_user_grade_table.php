<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGradeTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_grade', function (Blueprint $table) {
			$table->increments('grade_id');
			$table->string('grade_name', 50)->nullable()->comment('级别名称');
			$table->string('grade_name_en', 50)->nullable();
			$table->string('grade_name_tw', 50)->nullable();
			$table->string('grade_img', 50)->nullable()->comment('图标');
			$table->string('ug_self_vol', 20)->nullable()->default('0')->comment('升级所需自身交易量');
			$table->integer('ug_recommend_grade')->unsigned()->nullable()->default(0)->comment('升级需推荐会员级别');
			$table->integer('ug_recommend_num')->unsigned()->nullable()->default(0)->comment('升级需推荐的会员数');
			$table->string('ug_total_vol', 20)->nullable()->default('0')->comment('升级所需所有直推总交易量');
			$table->string('ug_direct_vol', 20)->nullable()->default('0')->comment('升级所需单个直推用户交易量');
			$table->integer('ug_direct_vol_num')->unsigned()->nullable()->default(0)->comment('升级所需直推用户达到交易量用户数量');
			$table->string('ug_direct_recharge', 20)->nullable()->default('0')->comment('升级所需单个直推用户充值量');
			$table->integer('ug_direct_recharge_num')->unsigned()->nullable()->default(0)->comment('升级所需直推用户达到充值量用户数量');
			$table->string('bonus', 100)->nullable()->comment('分红权益');
			$table->boolean('status')->nullable()->default(1)->comment('状态');
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
		Schema::drop('user_grade');
	}
}
