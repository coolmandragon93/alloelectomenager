<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Brand;

class AddSlugToBrands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('slug');
            $table->timestamps();
        });

        $brands = Brand::all();

        foreach($brands as $brand) {
            $brand->slug = str_slug($brand->name, '-');
            $brand->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(["slug", "updated_at", "created_at"]);

        });
    }
}
