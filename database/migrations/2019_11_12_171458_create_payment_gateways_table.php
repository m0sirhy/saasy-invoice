<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\PaymentGateway;

class CreatePaymentGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('library');
            $table->integer('active')->default(0);
            $table->timestamps();
        });

        PaymentGateway::create([
            'name' => 'Authorize.net CIM',
            'library' => 'AuthorizeNetApi_Api',
            'active' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_gateways');
    }
}
