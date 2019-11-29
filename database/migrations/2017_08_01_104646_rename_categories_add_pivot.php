<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCategoriesAddPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('art_categories','category_types');
        
        Schema::create('categories',function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_type_id');
            $table->string('categorizable_type');
            $table->unsignedInteger('categorizable_id');
            $table->timestamps();
        });

        Schema::table('categories', function(Blueprint $table) {
            $table->foreign('category_type_id')->references('id')->on('category_types')->onDelete('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
        
        Schema::rename('category_types','art_categories');
    }
}
