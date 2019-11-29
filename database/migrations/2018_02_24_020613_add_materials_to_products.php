<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class AddMaterialsToProducts extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('material_to_product', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('material_id');
                $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
                $table->unsignedInteger('product_id');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->timestamps();
            });

            Schema::table('materials', function (Blueprint $table) {
                $table->unsignedInteger('product_type_id')->default(2);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('material_to_product');
        }
    }
