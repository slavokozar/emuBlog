<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportemuCounties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sportemu_counties', function (Blueprint $table) {
            $table->increments('id');
            $table->increments('name');
            $table->timestamps();
        });

        Schema::table('sportemu_counties', function (Blueprint $table) {
            $table->foreign('resort_id')->references('id')->on('sportemu_resorts');
            $table->foreign('user_id')->references('id')->on('sportemu_users');
            $table->foreign('event_id')->references('id')->on('sportemu_events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::table('sportemu_users_events', function (Blueprint $table) {
            $table->dropForeign(['resort_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['event_id']);
        });

        Schema::dropIfExists('sportemu_counties');
    }
}
