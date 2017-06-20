<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportemuResortsSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sportemu_resorts_sports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('resort_id');
            $table->unsignedInteger('sport_id');
        });

        \Schema::table('sportemu_resorts_sports', function (Blueprint $table) {
            $table->foreign('sport_id')->references('id')->on('sportemu_sports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::table('sportemu_resorts_sports', function (Blueprint $table) {
            $table->dropForeign(['sport_id']);
        });

        Schema::dropIfExists('sportemu_resorts_sports');
    }
}
