<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid')->index();
            $table->string('type');
            $table->unsignedInteger('buyer_id');
            $table->integer('delivery_amount');
            $table->integer('products_amount');
            $table->integer('package_amount')->default(0);
            $table->string('currency')->default('EUR');
            $table->string('state')->default('initial');
            $table->boolean('sandbox');
            $table->unsignedInteger('payment_id')->default(1); // LiqPay

            $table->string('delivery_service');
            $table->string('delivery_country');
            $table->string('delivery_city');
            $table->string('delivery_street');
            $table->string('delivery_house');
            $table->string('delivery_postcode');
            $table->string('delivery_name');
   //        $table->string('delivery_last_name');
            $table->string('delivery_phone');
            $table->string('delivery_id');
            $table->string('delivery_created_at')->nullable();
            $table->string('delivery_delivered_at')->nullable();

            $table->boolean('payed')->default(0);
            $table->boolean('available')->default(0);
            $table->boolean('reserved')->default(0);
            $table->boolean('produced')->default(0);
            $table->boolean('packed')->default(0);
            $table->boolean('delivered')->default(0);
            $table->boolean('protected')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
