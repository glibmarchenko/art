<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRejectedFieldsToIsActive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('rejected', 'is_active');
            $table->renameColumn('active', 'email_confirmed');
        });

        DB::table('users')->update(['is_active' => DB::raw('!is_active')]);

        Schema::table('galleries', function (Blueprint $table) {
            $table->renameColumn('rejected', 'is_active');
        });

        DB::table('galleries')->update(['is_active' => DB::raw('!is_active')]);

        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('rejected', 'is_active');
        });

        DB::table('products')->update(['is_active' => DB::raw('!is_active')]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->update(['is_active' => DB::raw('!is_active')]);

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('is_active', 'rejected');
            $table->renameColumn('email_confirmed', 'active');
        });

        DB::table('galleries')->update(['is_active' => DB::raw('!is_active')]);

        Schema::table('galleries', function (Blueprint $table) {
            $table->renameColumn('is_active', 'rejected');
        });

        DB::table('products')->update(['is_active' => DB::raw('!is_active')]);

        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('is_active', 'rejected');
        });
    }
}
