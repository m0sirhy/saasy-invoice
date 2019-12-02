<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\InvoiceStatus;

class CreateInvoiceStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->timestamps();
        });
        $statuses = ['Draft', 'Sent', 'Viewed', 'Unpaid', 'Over Due', 'Paid'];
        foreach ($statuses as $status) {
            InvoiceStatus::create(['status' => $status]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_statuses');
    }
}
