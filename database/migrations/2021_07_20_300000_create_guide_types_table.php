<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuideTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guide_types', function (Blueprint $table) {
            $table->increments('guide_type_id');
            $table->string('guide_type_title');
            $table->text('guide_type_desc')->nullable();
            $table->string('guide_type_icon');
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
        Schema::dropIfExists('guide_types');
    }
}
