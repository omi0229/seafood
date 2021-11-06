<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->comment('分類ID');
            $table->string('name', 50)->comment('規格名稱');
            $table->integer('original_price')->comment('原價');
            $table->integer('selling_price')->comment('售價');
            $table->integer('inventory')->comment('庫存');
            $table->string('unit', 5)->comment('單位');
            $table->timestamps();
            $table->softDeletes();

            $table->index('product_id');
            $table->index('sales_status');
            $table->index('show_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_specifications');
    }
}
