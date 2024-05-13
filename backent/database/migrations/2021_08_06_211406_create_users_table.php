<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->increments('user_id')->comment('主键');
			$table->integer('id')->unsigned()->nullable()->default(0)->comment('代理商后台必须字段');
			$table->string('name')->nullable()->default('')->comment('代理商后台必须字段');
			$table->string('account', 100)->nullable()->comment('主账户');
			$table->boolean('account_type')->nullable()->comment('账户类型 1手机 2邮箱');
			$table->string('username', 100)->default('')->unique('username')->comment('用户名');
			$table->integer('referrer')->unsigned()->default(0)->comment('推荐人ID 这里指代理');
			$table->integer('pid')->unsigned()->default(0)->index('pid')->comment('父级ID');
			$table->integer('deep')->unsigned()->default(0)->comment('推荐关系层级');
			$table->text('path')->nullable();
			$table->integer('country_id')->nullable();
			$table->string('country_code', 10)->nullable()->comment('国家代号');
			$table->char('phone', 12)->default('')->comment('用户电话');
			$table->boolean('phone_status')->default(0);
			$table->string('email', 100)->default('')->comment('用户邮箱');
			$table->boolean('email_status')->default(0);
			$table->string('avatar', 200)->nullable()->default('head_image/head_default.png')->comment('用户头像');
			$table->string('google_token')->nullable()->comment('谷歌验证');
			$table->boolean('google_status')->default(0);
			$table->boolean('second_verify')->default(0)->comment('是否二次验证');
			$table->string('password', 80)->default('')->comment('用户登录密码');
			$table->string('payword', 80)->default('')->comment('用户支付密码');
			$table->string('invite_code', 50)->nullable()->default('')->comment('邀请码');
			$table->string('purchase_code', 50)->nullable()->default('')->comment('申购码');
			$table->boolean('user_grade')->default(1)->comment('用户级别 默认1');
			$table->boolean('user_identity')->default(1)->comment('用户身份 默认1- 普通用户');
			$table->boolean('is_agency')->default(0)->comment('是否代理');
			$table->boolean('is_place')->default(0)->comment('是否渠道商');
			$table->boolean('user_auth_level')->default(0)->comment('用户认证级别 0未认证 1初级认证 2高级认证');
			$table->boolean('is_system')->default(0)->comment('是否系统账户');
			$table->boolean('contract_deal')->nullable()->default(0);
			$table->string('login_code', 20)->default('')->comment('登录码');
			$table->boolean('status')->default(1)->comment('用户状态 0冻结 1正常');
			$table->boolean('trade_status')->nullable()->default(1)->comment('交易状态 0锁定 1正常');
			$table->boolean('trade_verify')->nullable()->default(0)->comment('交易是否密码验证');
			$table->boolean('contract_anomaly')->nullable()->default(0);
			$table->string('reg_ip', 20)->default('')->comment('注册ip');
			$table->dateTime('last_login_time')->nullable()->comment('登录时间');
			$table->string('last_login_ip', 20)->nullable()->comment('登录IP');
			$table->timestamps();
			$table->string('remember_token')->nullable();
			$table->float('subscribe_rebate_rate', 10, 4)->nullable();
			$table->float('contract_rebate_rate', 10, 4)->nullable();
			$table->float('option_rebate_rate', 10, 4)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}
}
