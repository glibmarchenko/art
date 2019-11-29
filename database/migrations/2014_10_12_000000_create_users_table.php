<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('pseudonym')->nullable();
            $table->string('nickname')->nullable();
            $table->text('description')->nullable();

            // Role (0=new) (1=client) (2=artist) (9=admin)
            $table->integer('role')->default(0);
            $table->string('avatar')->nullable();

            $table->string('email')->unique();
            $table->string('password');

            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('house_number')->nullable();
            $table->string('apartment_number')->nullable();
            $table->string('phone')->nullable();
            $table->text('note')->nullable();

            // After success registration, user will be redirected to this location
            $table->string('registered_from_url')->nullable();

            // Registered through socials
            $table->string('soc_vk')->nullable();
            $table->string('soc_google')->nullable();
            $table->string('soc_facebook')->nullable();
            $table->boolean('temp_email')->default(0);
            $table->boolean('no_password')->default(0);

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
