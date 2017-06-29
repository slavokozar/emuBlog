<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportemuCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sportemu_countries', function (Blueprint $table) {
            $table->increments('id');
            $table->increments('name');
            $table->timestamps();
        });

        Schema::table('sportemu_countries', function (Blueprint $table) {
            $table->foreign('region_id')->references('id')->on('sportemu_regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::table('sportemu_countries', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
        });

        Schema::dropIfExists('sportemu_countries');
    }
}
