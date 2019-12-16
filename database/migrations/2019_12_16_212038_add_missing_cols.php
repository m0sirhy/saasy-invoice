<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingCols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->uuid('uuid');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->float('unit_price');
        });
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->string('name');
            $table->float('unit_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
