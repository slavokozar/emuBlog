<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportemuResorts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sportemu_resorts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('address_street');
            $table->integer('address_zip');
            $table->string('address_city');
            $table->integer('address_county_id')->nullable();
            $table->float('address_latitude', 8, 2);
            $table->float('address_longitude', 8, 2);
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });


        \Schema::table('sportemu_resorts_sports', function (Blueprint $table) {
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
        \Schema::table('sportemu_resorts_sports', function (Blueprint $table) {
            $table->dropForeign(['resort_id']);
        });

        Schema::dropIfExists('sportemu_resorts');
    }
}
