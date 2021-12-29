<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToDiscountRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discount_records', function (Blueprint $table) {
            $table->dateTime('used_at')->after('orders_id')->nullable()->comment('使用時間');
            $table->dateTime('received_at')->after('orders_id')->nullable()->comment('領取時間');
            $table->uuid('cart_id')->after('orders_id')->nullable()->comment('購物車ID');
            $table->integer('member_id')->after('orders_id')->nullable()->comment('領取優惠劵的會員id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discount_records', function (Blueprint $table) {
            $table->dropColumn('used_at');
            $table->dropColumn('received_at');
            $table->dropColumn('cart_id');
            $table->dropColumn('member_id');
        });
    }
}
