<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('');
            $table->string('email')->default('');
            $table->string('address')->nullable();;
            $table->string('address2')->nullable();;
            $table->string('city')->nullable();;
            $table->string('state')->nullable();;
            $table->string('zipcode')->nullable();;
            $table->float('balance', 10,2)->default(0.00);
            $table->float('total_paid', 10,2)->default(0.00);
            $table->string('crm_id')->default('');
            $table->datetime('terms_accepted_at')->nullable();
            $table->uuid('uuid');
            $table->datetime('deleted_at')->nullable();;
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
        Schema::dropIfExists('clients');
    }
}
