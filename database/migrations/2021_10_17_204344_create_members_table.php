<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('cellphone', 10)->unique()->comment('手機號碼(帳號)');
            $table->string('password', 255)->comment('密碼');
            $table->string('name', 20)->comment('姓名');
            $table->string('email', 200)->nullable()->comment('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('telephone', 20)->nullable()->comment('市內電話');
            $table->string('zipcode', 20)->nullable()->comment('郵遞區號');
            $table->string('country', 20)->nullable()->comment('城市');
            $table->string('city', 20)->nullable()->comment('地區');
            $table->string('address', 200)->nullable()->comment('地址');
            $table->rememberToken();
            $table->tinyInteger('active')->comment('帳號啟用狀態(0 => 停用, 1 => 啟用)')->default(1)->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->index('cellphone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
