<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportemuFacilitiesResorts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sportemu_facilities_resorts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('resort_id');
            $table->unsignedInteger('facility_id');
        });

        \Schema::table('sportemu_facilities_resorts', function (Blueprint $table) {
            $table->foreign('resort_id')->references('id')->on('sportemu_resorts');
            $table->foreign('facility_id')->references('id')->on('sportemu_facilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sportemu_facilities_resorts', function (Blueprint $table) {
            $table->dropForeign(['resort_id']);
            $table->dropForeign(['facility_id']);
        });

        Schema::dropIfExists('sportemu_facilities_resorts');
    }
}
