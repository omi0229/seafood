<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->comment('標題');
            $table->string('coupon', 50)->comment('優惠券代碼');
            $table->integer('full_amount')->comment('結帳時滿此數字即可滿足優惠金額');
            $table->integer('discount')->comment('折扣金額');
            $table->dateTime('start_date')->comment('開始時間');
            $table->dateTime('end_date')->comment('結束時間');
            $table->timestamps();
            $table->softDeletes();

            $table->index('coupon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
