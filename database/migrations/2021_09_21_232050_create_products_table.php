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
            $table->integer('product_front_cover_image_id')->comment('產品前台大圖ID');
            $table->text('keywords')->comment('關鍵字')->nullable();
            $table->longText('description')->comment('描述')->nullable();
            $table->tinyInteger('sales_status')->comment('是否暫停銷售(0 => 暫停, 1 => 開放)')->default(1)->unsigned();
            $table->tinyInteger('show_status')->comment('是否於上架管理顯示(0 => 不顯示, 1 => 顯示)')->default(1)->unsigned();
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
