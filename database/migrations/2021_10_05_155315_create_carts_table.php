<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('cart_id');
            $table->integer('member_id')->nullable();
            $table->integer('specifications_id')->unsigned();
            $table->integer('count')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->index('cart_id');
            $table->index('member_id');
            $table->index('specifications_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
