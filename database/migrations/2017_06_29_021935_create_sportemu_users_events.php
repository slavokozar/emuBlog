<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportemuUsersEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sportemu_users_events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::table('sportemu_users_events', function (Blueprint $table) {
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
        Schema::dropIfExists('sportemu_users_events');

        Schema::table('sportemu_users_events', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['event_id']);
        });
    }
}
