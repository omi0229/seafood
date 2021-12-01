<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->string('type')->primary();
            $table->string('name')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();
        });

        DB::table('pages')->insert([ 'type' => 'about', 'name' => '關於海龍王' ]);
        DB::table('pages')->insert([ 'type' => 'shopping_explanation', 'name' => '購物說明' ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
