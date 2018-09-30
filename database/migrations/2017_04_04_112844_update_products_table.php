<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('aswo_id');
            $table->text('description');
            $table->string('image_link');
            $table->string('price');
            $table->string('condition');
            $table->string('availability');
            $table->string('google_product_category');
            $table->string('gtin');
            $table->string('mpn');
            $table->string('brand_name');

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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(["aswo_id", "description", "image_link", "price", "condition", "availability", "google_product_category", "gtin", "mpn", "brand_name", "created_at", "updated_at"]);
        });
    }
}
