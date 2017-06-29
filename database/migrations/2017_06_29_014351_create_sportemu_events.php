<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportemuEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sportemu_events', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('county');
            $table->dateTime('time');
            $table->float('price');

            $table->string('website');

            $table->timestamps();
        });

        // Foreign Keys
        Schema::table('sportemu_events', function (Blueprint $table) {
            $table->foreign('resort_id')->references('id')->on('sportemu_resorts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::table('sportemu_events', function (Blueprint $table) {
            $table->dropForeign(['resort_id']);
        });

        Schema::dropIfExists('sportemu_events');
    }
}
