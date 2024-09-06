<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsReceivedCollumnsIntoQuestLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quest_logs', function (Blueprint $table) {
            $table->boolean('is_received')->after('is_done')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quest_logs', function (Blueprint $table) {
            $table->dropColumn('is_received');
        });
    }
}
