<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('product_types_id')->comment('分類ID');
            $table->string('title', 50)->comment('標題');
            $table->longText('content')->comment('內文')->nullable();
            $table->string('web_img_name', 50)->comment('電腦版圖片名稱')->nullable();
            $table->string('web_img', 200)->comment('電腦版圖片路徑')->nullable();
            $table->string('mobile_img_name', 50)->comment('手機板圖片名稱')->nullable();
            $table->string('mobile_img', 200)->comment('手機板圖片路徑')->nullable();
            $table->text('keywords')->comment('關鍵字')->nullable();
            $table->longText('description')->comment('描述')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('product_types_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
