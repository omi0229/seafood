<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->nullable()->comment('會員ID');
            $table->string('type', 20)->comment('公告類型');
            $table->text('text')->comment('內容');
            $table->tinyInteger('is_load')->default(0)->comment('是否已讀(0 => 未讀, 1 => 已讀)');
            $table->timestamps();
            $table->softDeletes();

            $table->index('member_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
