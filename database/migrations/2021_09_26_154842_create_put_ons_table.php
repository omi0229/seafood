<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePutOnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('put_ons', function (Blueprint $table) {
            $table->id();
            $table->integer('directories_id')->comment('目錄ID');
            $table->integer('product_id')->comment('產品ID');
            $table->dateTime('start_date')->comment('開始上架時間')->nullable();
            $table->dateTime('end_date')->comment('下架時間')->nullable();
            $table->tinyInteger('status')->comment('上架狀態(0 => 下架, 1 => 上架-不依據時間上下架, 2 => 上架-依據時間上下架)')->default(0)->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->index('directories_id');
            $table->index('product_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('put_ons');
    }
}
