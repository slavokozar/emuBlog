<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportemuRegions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sportemu_regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

         Schema::table('sportemu_regions', function (Blueprint $table) {
            $table->foreign('county_id')->references('id')->on('sportemu_counties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
         Schema::table('sportemu_regions', function (Blueprint $table) {
            $table->dropForeign(['county_id']);
        });

        Schema::dropIfExists('sportemu_regions');
    }
}
