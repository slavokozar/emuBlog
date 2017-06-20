<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('sportemu_countries', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->nullableTimestamps();
        });

        Schema::table('sportemu_regions',function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('sportemu_countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::table('sportemu_regions', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
        });

        Schema::dropIfExists('sportemu_countries');
    }
}
