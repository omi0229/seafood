<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_records', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->comment('優惠類型');
            $table->integer('discount_codes_id')->comment('優惠ID');
            $table->integer('orders_id')->comment('訂單ID');
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
            $table->index('discount_codes_id');
            $table->index('orders_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_records');
    }
}
