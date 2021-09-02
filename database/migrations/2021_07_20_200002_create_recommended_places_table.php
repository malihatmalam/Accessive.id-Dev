<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendedPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommended_places', function (Blueprint $table) {
            $table->increments('recommended_place_id');
            $table->unsignedInteger('place_id');
            $table->foreign('place_id')->references('place_id')->on('places')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('top_places_order')->nullable();  
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
        Schema::dropIfExists('recommended_places');
    }
}
