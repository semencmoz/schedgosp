<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('dep_id');
            $table->foreign('dep_id')
                ->references('id')->on('depts')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->double('qtty')->nullable(false);
            $table->dateTime('date_start')->nullable(false);
            $table->dateTime('date_end');
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
        Schema::dropIfExists('quotas');
    }
}
