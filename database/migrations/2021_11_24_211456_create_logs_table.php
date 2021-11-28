<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->comment('log類型(payment => 繳費)')->nullable();
            $table->integer('user_id')->comment('使用者ID')->nullable()->unsigned();
            $table->integer('data_id')->comment('此log相關聯ID')->nullable()->unsigned();
            $table->longText('content')->comment('log內容(序列化資料)')->nullable();
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
        Schema::dropIfExists('logs');
    }
}
