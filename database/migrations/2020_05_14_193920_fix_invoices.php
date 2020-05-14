<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Invoice;
use App\Payment;
use App\Client;

class FixInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $invoices = Invoice::whereIn('id', [6678, 6884, 6867, 6868, 6679])
            ->update([
                'balance' => 0.00,
                'invoice_status_id' => 6,
            ]);
        $invoices = Invoice::whereIn('id', [6678, 6884, 6867, 6868, 6679])->get();
        foreach ($invoices as $invoice) {
            $paid = $invoice->client->payments
                ->where('payment_type', '!=', 2)
                ->sum('amount');
            $invoice->client->update([
                'balance' => $invoice->client->invoices->sum('balance'),
                'total_paid' => $paid,
            ]);
        }
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
