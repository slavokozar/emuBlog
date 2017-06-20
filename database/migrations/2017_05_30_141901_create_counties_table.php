<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('sportemu_counties', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('region_id');

            $table->string('name');
            $table->nullableTimestamps();
        });

        Schema::table('sportemu_resorts', function (Blueprint $table) {
            $table->foreign('address_county_id')->references('id')->on('sportemu_counties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::table('sportemu_resorts', function (Blueprint $table) {
            $table->dropForeign(['address_county_id']);
        });

        Schema::dropIfExists('sportemu_counties');
    }
}
