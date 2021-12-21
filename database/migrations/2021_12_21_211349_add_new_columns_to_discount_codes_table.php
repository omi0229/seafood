<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discount_codes', function (Blueprint $table) {
            $table->text('bookmark')->after('end_date')->nullable()->comment('備註');
            $table->tinyInteger('revenue_share')->after('end_date')->nullable()->comment('分潤');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discount_codes', function (Blueprint $table) {
            $table->dropColumn('bookmark');
            $table->dropColumn('revenue_share');
        });
    }
}
