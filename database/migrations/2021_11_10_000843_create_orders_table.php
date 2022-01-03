<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_trade_no', 20)->nullable()->comment('訂單編號');
            $table->integer('member_id')->unsigned()->comment('會員ID');
            $table->string('name', 20)->comment('姓名');
            $table->string('cellphone', 10)->comment('手機號碼');
            $table->string('email', 200)->nullable()->comment('email');
            $table->string('zipcode', 20)->comment('郵遞區號');
            $table->string('country', 20)->comment('城市');
            $table->string('city', 20)->comment('地區');
            $table->string('address', 200)->comment('地址');
            $table->bigInteger('freight_id')->unsigned()->nullable()->comment('運費ID');
            $table->string('freight_name', 200)->nullable()->comment('運費名稱');
            $table->integer('freight')->unsigned()->default(0)->comment('運費');
            $table->tinyInteger('delivery_method')->comment('配送方式(1 => 宅配到府)')->default(1)->unsigned();
            $table->tinyInteger('payment_method')->comment('付款方式(1 => 信用卡, 2 => ATM, 3 => LinePay)')->default(1)->unsigned();
            $table->tinyInteger('invoice_method')->comment('發票資訊(1 => 個人發票, 2 => 公司用三聯式發票)')->default(1)->unsigned();
            $table->string('invoice_tax_id_number', 20)->nullable()->comment('統一編號');
            $table->string('invoice_name', 100)->nullable()->comment('發票抬頭');
            $table->text('bookmark')->nullable()->comment('備註');
            $table->tinyInteger('order_status')->comment('訂單狀態(0 => 新單, 1 => 收款, 2 => 出貨, -1 => 取消, -2 => 退貨, 3 => 完成)')->default(0);
            $table->tinyInteger('payment_status')->comment('付款狀態(0 => 尚未收款, 1 => 付款成功, -1 => 付款金額錯誤, -2 => 付款失敗)')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('member_id');
            $table->index('order_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
