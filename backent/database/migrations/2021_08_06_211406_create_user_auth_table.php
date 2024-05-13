<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAuthTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_auth', function (Blueprint $table) {
			$table->integer('id', true);
			$table->integer('user_id')->comment('用户ID');
			$table->integer('country_id')->nullable();
			$table->string('country_code', 30)->nullable()->comment('国家代码');
			$table->string('realname', 55)->comment('真实姓名');
			$table->string('id_card')->comment('证件号码');
			$table->string('birthday', 50)->nullable()->comment('出生日期');
			$table->string('address')->nullable()->comment('居住地址');
			$table->string('city', 30)->nullable()->comment('城市');
			$table->string('postal_code', 30)->nullable()->comment('邮政编码');
			$table->string('extra')->nullable()->comment('额外信息');
			$table->string('phone', 30)->nullable()->comment('电话号码');
			$table->boolean('type')->default(1)->comment('证件类型 默认1身份证');
			$table->string('front_img')->nullable()->comment('正面照');
			$table->string('back_img')->nullable()->comment('背面照');
			$table->string('hand_img')->nullable()->comment('手持照');
			$table->dateTime('check_time')->nullable()->comment('审核时间');
			$table->boolean('primary_status')->nullable()->default(1)->comment('初级认证状态 1已认证');
			$table->boolean('status')->nullable()->default(0)->comment('高级认证状态 0未认证,1待审核,2已通过,3已驳回');
			$table->string('remark')->nullable();
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
		Schema::drop('user_auth');
	}
}
