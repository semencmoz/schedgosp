<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotas', function (Blueprint $table) {
            $table->dropColumn('date_start');
            $table->dropColumn('date_end');
            $table->dateTime('date');
            $table->integer('qttyused');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotas', function (Blueprint $table) {
            //
        });
    }
}
