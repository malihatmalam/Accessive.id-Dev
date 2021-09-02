<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->increments('guide_id');
            $table->unsignedInteger('guide_type_id');
            $table->foreign('guide_type_id')->references('guide_type_id')->on('guide_types')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('place_id');
            $table->foreign('place_id')->references('place_id')->on('places')->onUpdate('cascade')->onDelete('cascade');
            $table->text('guide_desc')->nullable();
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
        Schema::dropIfExists('guides');
    }
}
