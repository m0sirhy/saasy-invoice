<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Invoice;

class OverDue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marks invoices as overdue';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $invoices = Invoice::where('balance', '>', 0)
            ->where('invoice_status_id', '!=', OVER_DUE)
            ->where('invoice_status_id', '!=', DRAFT)
            ->where('due_date', '<=', now())
            ->get();
        foreach ($invoices as $invoice) {
            $invoice->invoice_status_id = 5;
            $invoice->save();
        }
    }
}
