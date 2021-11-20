<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freights', function (Blueprint $table) {
            $table->id();
            $table->integer('parents_id')->unsigned()->default(0)->comment('上層ID');
            $table->integer('floor')->comment('層級');
            $table->string('title', 100)->nullable()->comment('運費標題');
            $table->dateTime('start_date')->nullable()->comment('開始時間');
            $table->dateTime('end_date')->nullable()->comment('結束時間');
            $table->integer('default')->nullable()->default(0)->comment('預設值(0 => 否, 1 => 是，只能有一筆，不受開始時間及結束時間影響)');
            $table->integer('sort')->nullable()->comment('排序(第2層使用)');
            $table->integer('status')->nullable()->comment('是否顯示(第2層使用 0 => 否, 1 => 是)');
            $table->integer('start_total')->nullable()->comment('起始金額(第3層使用)');
            $table->integer('end_total')->nullable()->comment('上限金額(第3層使用)');
            $table->integer('freight')->nullable()->comment('運費');
            $table->timestamps();
            $table->softDeletes();

            $table->index('parents_id');
            $table->index('floor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freights');
    }
}
