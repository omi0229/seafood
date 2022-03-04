<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumns0303 extends Migration
{
    private $list = ['cooking_types', 'directories', 'news_types'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->list as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->integer('location')->after('name')->default(0)->comment('排序(數字)');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->list as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('location');
            });
        }
    }
}
