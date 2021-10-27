<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForgetPasswordLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forget_password_logs', function (Blueprint $table) {
            $table->id();
            $table->string('cellphone', 10)->comment('手機號碼(帳號)');
            $table->string('ip', 50)->nullable()->comment('IP');
            $table->timestamps();
            $table->softDeletes();

            $table->index('cellphone');
            $table->index('ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forget_password_logs');
    }
}
