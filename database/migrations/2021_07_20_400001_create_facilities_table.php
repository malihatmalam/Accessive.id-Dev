<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->increments('facility_id');
            $table->unsignedInteger('place_id');
            $table->foreign('place_id')->references('place_id')->on('places')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('facility_type_id');
            $table->foreign('facility_type_id')->references('facility_type_id')->on('facility_types')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('is_deleted')->default(false);  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facilities');
    }
}
