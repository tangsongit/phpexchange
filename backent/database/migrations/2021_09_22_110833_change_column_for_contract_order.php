<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnForContractOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_order', function (Blueprint $table) {
            $table->unique('buy_id');
            $table->unique('sell_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_order', function (Blueprint $table) {
            $table->dropUnique('buy_id');
            $table->dropUnique('sell_id');
        });
    }
}
