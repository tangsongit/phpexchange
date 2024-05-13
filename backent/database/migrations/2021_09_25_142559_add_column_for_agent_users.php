<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnForAgentUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_users', function (Blueprint $table) {
            // 渠道商设置代理商下级的分佣比例 参照的数据优先级为 可设合约分佣比例>合约分佣比例>渠道商返佣比例
            $table->decimal('rebate_rate_canset', 6, 2)->nullable()->comment('分佣比例（可设置下级的分佣比例）');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agent_users', function (Blueprint $table) {
            $table->dropColumn('rebate_rate_canset');
        });
    }
}
