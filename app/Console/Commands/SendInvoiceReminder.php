<?php

namespace App\Console\Commands;

use App\Setting;
use App\Invoice;
use App\Events\InvoiceReminder;
use Illuminate\Console\Command;

class SendInvoiceReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Invoice Reminders to Clients';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $setting = Setting::find('1');
        $remind = [
            1 => 'due_date',
            2 => 'invoice_date'
        ];
        //Send the first reminder if set to
        if ($setting->remind_enable1 == 1) {
            $reminder = $remind[$setting->remind_after1];
            $now = now()->startOfDay();
            $subDays = $now->subDays($setting->remind_days1)
                ->format('Y-m-d');
            $invoices = Invoice::where('invoice_status_id', '!=', PAID)
                ->where('invoice_status_id', '!=', DRAFT)
                ->where('balance', '!=', 0)
                ->where($reminder, $subDays)
                ->with('Client')
                ->get();
            foreach ($invoices as $invoice) {
                event(new InvoiceReminder($invoice));
            }
        }

        //Send the second reminder if set to
        if ($setting->remind_enable2 == 1) {
            $reminder = $remind[$setting->remind_after2];
            $now = now()->startOfDay();
            $subDays = $now->subDays($setting->remind_days2)
                ->format('Y-m-d');
            $invoices = Invoice::where('invoice_status_id', '!=', PAID)
                ->where('invoice_status_id', '!=', DRAFT)
                ->where('balance', '!=', 0)
                ->where($reminder, $subDays)
                ->with('Client')
                ->get();
            foreach ($invoices as $invoice) {
                event(new InvoiceReminder($invoice));
            }
        }
        
        //Send the third reminder if set to
        if ($setting->remind_enable3 == 1) {
            $reminder = $remind[$setting->remind_after3];
            $now = now()->startOfDay();
            $subDays = $now->subDays($setting->remind_days3)
                ->format('Y-m-d');
            $invoices = Invoice::where('invoice_status_id', '!=', PAID)
                ->where('invoice_status_id', '!=', DRAFT)
                ->where('balance', '!=', 0)
                ->where($reminder, $subDays)
                ->with('Client')
                ->get();
            foreach ($invoices as $invoice) {
                event(new InvoiceReminder($invoice));
            }
        }
    }
}
