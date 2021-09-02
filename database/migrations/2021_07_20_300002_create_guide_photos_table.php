<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guide_photos', function (Blueprint $table) {
            $table->increments('guide_photo_id');
            $table->unsignedInteger('guide_id');
            $table->foreign('guide_id')->references('guide_id')->on('guides')->onUpdate('cascade')->onDelete('cascade');
            $table->string('guide_photo_url')->nullable();
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
