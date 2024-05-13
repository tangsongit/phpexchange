<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-20 16:11:12
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-20 16:15:32
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToAgentUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_users', function (Blueprint $table) {
            $table->decimal('place_rebate_rate', 6, 2)->after('password')->nullable()->comment('渠道商返佣比例');
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
            $table->dropColumn('place_rebate_rate');
        });
    }
}
