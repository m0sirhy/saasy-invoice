<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('billing_types');
        Schema::create('billings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('monthly_fee', 6, 2)->default(0);
            $table->decimal('monthly_min', 6, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('billing_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('billing_id');
            $table->integer('product_id');
            $table->string('alt_id');
            $table->decimal('price_per', 6, 2)->default(0);
            $table->integer('after_min');
            $table->decimal('price_after', 6, 2)->default(0);
            $table->decimal('costs', 6, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billings');
        Schema::dropIfExists('billing_items');
    }
}
