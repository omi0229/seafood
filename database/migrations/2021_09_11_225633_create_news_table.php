<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->integer('news_types_id')->comment('分類ID');
            $table->string('title', 50)->comment('標題');
            $table->dateTime('start_date')->comment('發表時間');
            $table->dateTime('end_date')->comment('截止時間');
            $table->string('href', 200)->comment('超連結')->nullable();
            $table->longText('description')->comment('描述')->nullable();
            $table->text('keywords')->comment('關鍵字')->nullable();
            $table->string('web_img_name', 300)->comment('電腦版圖片名稱')->nullable();
            $table->string('web_img', 200)->comment('電腦版圖片路徑')->nullable();
            $table->string('mobile_img_name', 300)->comment('手機板圖片名稱')->nullable();
            $table->string('mobile_img', 200)->comment('手機板圖片路徑')->nullable();
            $table->tinyInteger('target')->comment('開啟方式(0 => 直接開啟, 1 => 開新視窗)')->default(1)->unsigned();
            $table->tinyInteger('carousel')->comment('設為跑馬燈顯示(0 => 不顯示, 1 => 顯示)')->default(0)->unsigned();
            $table->tinyInteger('status')->comment('顯示(0 => 不顯示, 1 => 顯示)')->default(0)->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->index('news_types_id');
            $table->index('carousel');
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
        Schema::dropIfExists('news');
    }
}
