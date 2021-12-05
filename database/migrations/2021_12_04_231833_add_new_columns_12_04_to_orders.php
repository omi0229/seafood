<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumns1204ToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('RtnMsg', 200)->after('shipment_at')->nullable()->comment('(物流資料)物流狀態');
            $table->integer('RtnCode')->after('shipment_at')->nullable()->comment('(物流資料)物流狀態代碼');
            $table->string('BookingNote', 50)->after('shipment_at')->nullable()->comment('(物流資料)托運單號');
            $table->string('AllPayLogisticsID', 20)->after('shipment_at')->nullable()->comment('(物流資料)綠界科技的物流交易編號');
            $table->string('MerchantTradeNo', 20)->after('shipment_at')->nullable()->comment('(物流資料)廠商交易編號');

            $table->index('BookingNote');
            $table->index('AllPayLogisticsID');
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
            $table->dropColumn('RtnMsg');
            $table->dropColumn('RtnCode');
            $table->dropColumn('BookingNote');
            $table->dropColumn('AllPayLogisticsID');
            $table->dropColumn('MerchantTradeNo');
        });
    }
}
