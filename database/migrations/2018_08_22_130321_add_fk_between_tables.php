<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkBetweenTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('gallery_id')->nullable()->unsigned()->change();
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('restrict');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->unsigned()->change()->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('product_id')->nullable()->unsigned()->change();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');

            $table->integer('order_id')->nullable()->unsigned()->change();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
        });

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->integer('purchase_id')->nullable()->unsigned()->change();
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
        });

        Schema::table('category_product', function (Blueprint $table) {
            $table->integer('product_id')->nullable()->unsigned()->change();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::table('delivery_details', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->unsigned()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->unsigned()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->integer('buyer_id')->nullable()->unsigned()->change();
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('restrict');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->unsigned()->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('subscription_id')->nullable()->unsigned()->change();
            $table->foreign('subscription_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_gallery_id_foreign');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign('purchases_order_id_foreign');
            $table->dropForeign('purchases_product_id_foreign');
            $table->dropForeign('purchases_user_id_foreign');
        });

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->dropForeign('purchase_details_purchase_id_foreign');
        });

        Schema::table('category_product', function (Blueprint $table) {
            $table->dropForeign('category_product_product_id_foreign');
        });

        Schema::table('delivery_details', function (Blueprint $table) {
            $table->dropForeign('delivery_details_user_id_foreign');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign('galleries_user_id_foreign');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_buyer_id_foreign');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign('subscriptions_subscription_id_foreign');
            $table->dropForeign('subscriptions_user_id_foreign');
        });
    }
}
