<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportemuArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sportemu_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->timestamps();
        });

        // Foreign Keys
        Schema::table('sportemu_articles', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('sportemu_users');
            $table->foreign('resort_id')->references('id')->on('sportemu_resorts');
            $table->foreign('event_id')->references('id')->on('sportemu_events');
            $table->foreign('sport_id')->references('id')->on('sportemu_sports');
            $table->foreign('image_id')->references('id')->on('sportemu_images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sportemu_articles');

        Schema::table('sportemu_articles', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['resort_id']);
            $table->dropForeign(['event_id']);
            $table->dropForeign(['sport_id']);
            $table->dropForeign(['image_id']);
        });

    }
}
