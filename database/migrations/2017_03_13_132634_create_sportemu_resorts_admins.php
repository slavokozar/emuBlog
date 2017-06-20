<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportemuResortsAdmins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sportemu_resorts_admins', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('resort_id');
            $table->boolean('owner');
        });

        \Schema::table('sportemu_resorts_admins', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('sportemu_users');
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
        \Schema::table('sportemu_resorts_admins', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['resort_id']);
        });

        Schema::dropIfExists('sportemu_resorts_admins');
    }
}
