<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductMobileFrontCoverImageIdToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('product_mobile_front_cover_image_id')->after('product_front_cover_image_id')->nullable()->comment('產品前台大圖ID(mobile)');

            $table->index('product_mobile_front_cover_image_id');
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
            $table->dropColumn('product_mobile_front_cover_image_id');
        });
    }
}
