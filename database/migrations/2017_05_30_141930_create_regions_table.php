<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('sportemu_regions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('country_id');

            $table->string('name');
            $table->nullableTimestamps();
        });

        Schema::table('sportemu_counties',function (Blueprint $table) {
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
        \Schema::table('sportemu_counties', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
        });

        Schema::dropIfExists('sportemu_regions');
    }
}
