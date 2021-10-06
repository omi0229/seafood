<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('web_img_name', 50)->comment('電腦版圖片名稱')->nullable();
            $table->string('web_img', 200)->comment('電腦版圖片路徑')->nullable();
            $table->string('mobile_img_name', 50)->comment('手機板圖片名稱')->nullable();
            $table->string('mobile_img', 200)->comment('手機板圖片路徑')->nullable();
            $table->string('href', 200)->comment('超連結')->nullable();
            $table->tinyInteger('target')->comment('開啟方式(0 => 直接開啟, 1 => 開新視窗)')->default(1)->unsigned();
            $table->tinyInteger('status')->comment('是否顯示(0 => 不顯示, 1 => 顯示)')->default(0)->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
