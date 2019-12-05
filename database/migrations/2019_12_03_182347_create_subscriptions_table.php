<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id');
            $table->integer('billing_type_id');
            $table->date('last_invoice_date')->nullable();
            $table->integer('last_invoice_id')->nullable();
            $table->date('next_invoice_date');
            $table->integer('total_invoices')->default(0);
            $table->decimal('total_billed', 10, 2);
            $table->decimal('total_payed', 10, 2);
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
        Schema::dropIfExists('subscriptions');
    }
}
