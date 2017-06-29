<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportemuUsersSports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sportemu_users_sports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('sport_id');
        });

        // Foreign Keys
        Schema::table('sportemu_users_sports', function (Blueprint $table) {
            $table->foreign('sport_id')->references('id')->on('sportemu_sports');
            $table->foreign('user_id')->references('id')->on('sportemu_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sportemu_users_sports', function (Blueprint $table) {
            $table->dropForeign(['sport_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('sportemu_users_sports');
    }
}
