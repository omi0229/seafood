<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->comment('標題');
            $table->integer('records')->comment('優惠筆數');
            $table->integer('full_amount')->comment('結帳時滿此數字即可滿足優惠金額');
            $table->integer('discount')->comment('折扣金額');
            $table->tinyInteger('is_fixed')->comment('優惠代碼是否固定名稱(0 => 否, 1 => 是，欲產生的名稱為此欄位名稱)')->default(0)->unsigned();
            $table->string('fixed_name', 13)->nullable()->comment('優惠代碼固定名稱');
            $table->dateTime('start_date')->comment('開始時間');
            $table->dateTime('end_date')->comment('結束時間');
            $table->timestamps();
            $table->softDeletes();

            $table->index('fixed_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_codes');
    }
}
