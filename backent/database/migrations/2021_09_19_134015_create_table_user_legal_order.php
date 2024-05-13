<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUserLegalOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_legal_order', function (Blueprint $table) {
            $table->bigIncrements('id',true);
            $table->integer('user_id')->comment('用户id');
            $table->string('order_on',200)->comment('订单编号');
            $table->float('amount',20,8)->comment('订单金额');
            $table->float('number',20,8)->comment('订单数量');
            $table->float('unitPrice',20,8)->comment('单价');
            $table->string('currency',100)->comment('币种');
            $table->string('type',18)->comment('类型：buy买 sell卖');
            $table->string('status',4)->comment('订单状态：1待付款 2待放币，3申诉中 4交易完成 5已取消')->default(1);
            $table->timestamps();
            $table->string('failure_time',11)->comment('失效时间');
            $table->string('pay_type',3)->comment('购买类型：0币数量，1人民币');
            $table->string('remarks',50)->nullable()->comment('说明');
            $table->string('is_callback',3)->comment('回调：0没有，1已处理')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_legal_order');
    }
}
