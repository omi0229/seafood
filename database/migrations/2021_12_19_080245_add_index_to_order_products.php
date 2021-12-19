<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToOrderProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->index('orders_id');
            $table->index('product_id');
            $table->index('product_specifications_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropIndex('order_products_orders_id_index');
            $table->dropIndex('order_products_product_id_index');
            $table->dropIndex('order_products_product_specifications_id_index');
        });
    }
}
