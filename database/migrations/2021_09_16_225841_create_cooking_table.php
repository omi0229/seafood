<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooking', function (Blueprint $table) {
            $table->id();
            $table->string('cooking_types_id', 50)->comment('分類ID');
            $table->string('title', 50)->comment('標題');
            $table->dateTime('start_date')->comment('發表時間');
            $table->dateTime('end_date')->comment('截止時間');
            $table->string('href', 200)->comment('超連結')->nullable();
            $table->longText('description')->comment('描述')->nullable();
            $table->text('keywords')->comment('關鍵字')->nullable();
            $table->string('youtube_id', 50)->comment('youtube_id');
            $table->tinyInteger('target')->comment('開啟方式(0 => 直接開啟, 1 => 開新視窗)')->default(1)->unsigned();
            $table->tinyInteger('status')->comment('設為跑馬燈顯示(0 => 不顯示, 1 => 顯示)')->default(0)->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->index('cooking_types_id');
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
        Schema::dropIfExists('cooking');
    }
}
