<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alias');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('picture_material', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('picture_id');
            $table->unsignedInteger('material_id');
            $table->timestamps();
        });

        Schema::table('picture_material', function(Blueprint $table) {
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('Cascade');
            $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('Cascade');
        });
    }
    
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('picture_material');
        Schema::dropIfExists('materials');
    }
}
