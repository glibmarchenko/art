<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixRetardedProductStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('favorite');
            $table->dropColumn('rejected');
            $table->dropColumn('viewed');
            $table->dropColumn('top');
            $table->unsignedInteger('status_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
          $table->dropColumn('status_id');
          $table->boolean('favorite')->default(0);
          $table->boolean('rejected')->default(0);
          $table->boolean('viewed')->default(0);
          $table->boolean('top')->default(0);
        });

    }
}
