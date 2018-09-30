<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTables extends Migration
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
            $table->integer('cart_id')->unsigned();
            $table->string('payment_type');
            $table->integer('total_products');
            $table->integer('total_shipping');
            $table->text('deliver_datel');
            $table->text('deliver_dates');
            $table->integer('tax_rate');
            $table->integer('total_paid');
            $table->string('email');

            // Shipping
            $table->string('shipping_first_name');
            $table->string('shipping_last_name');
            $table->string('shipping_phone');
            $table->string('shipping_company');
            $table->text('shipping_address');
            $table->string('shipping_zip');
            $table->string('shipping_city');
            $table->string('shipping_country');

            // Billing
            $table->string('billing_first_name');
            $table->string('billing_last_name');
            $table->string('billing_phone');
            $table->string('billing_company');
            $table->text('billing_address');
            $table->string('billing_zip');
            $table->string('billing_city');
            $table->string('billing_country');

            $table->timestamps();
        });

        Schema::create('order_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->string('product_id');
            $table->string('name');
            $table->integer('price');
            $table->integer('quantity');

            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        Schema::create('order_histories', function(Blueprint $table){
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->string('state');

            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_lines');
        Schema::dropIfExists('order_histories');
        Schema::dropIfExists('orders');
    }
}
