<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumns1127ToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->date('ExpireDate')->after('payment_method')->nullable()->comment('(ATM繳費)繳費期限');
            $table->string('vAccount', 50)->after('payment_method')->nullable()->comment('(ATM繳費)繳費虛擬帳號');
            $table->string('BankCode', 10)->after('payment_method')->nullable()->comment('(ATM繳費)繳費銀行代碼');
            $table->string('TradeNo', 200)->after('payment_method')->nullable()->comment('(ATM繳費)綠界關聯訂單編號');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('ExpireDate');
            $table->dropColumn('vAccount');
            $table->dropColumn('BankCode');
            $table->dropColumn('TradeNo');
        });
    }
}
