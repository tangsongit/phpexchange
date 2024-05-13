<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumForUserTransferRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_transfer_record', function (Blueprint $table) {
            $table->tinyInteger('order_status')->default(1)->comment('是否审核：0未审核 1已审核 2驳回');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_transfer_record', function (Blueprint $table) {
            $table->dropColumn(['order_status']);
        });
    }
}
