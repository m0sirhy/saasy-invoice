<?php

namespace App\Console\Commands;

use DB;
use App\Client;
use App\Credit;
use App\Invoice;
use App\Payment;
use App\Product;
use App\ClientToken;
use App\InvoiceItem;
use Illuminate\Console\Command;

class MigrateNinja extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:ninja';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migration from InvoiceNinja';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->clients();
        $this->invoices();
        $this->invoiceItems();
        $this->payments();
        $this->credits();
    }

    public function credits()
    {
        $credits = DB::connection('invoice')->select('
            select * from credits
        ');
        foreach ($credits as $credit) {
            $completed = 0;
            if ($credit->balance == 0) {
                $completed = 1;
            }
            try {
                Credit::create([
                    'id' => $credit->id,
                    'client_id' => $credit->client_id,
                    'user_id' => 0,
                    'credit_date' => $credit->credit_date,
                    'amount' => $credit->amount,
                    'balance' => $credit->balance,
                    'completed' => $completed,
                    'private_notes' => $credit->private_notes,
                    'public_notes' => $credit->public_notes
                ]);
            } catch (\Exception $e) {
                $this->info('Credit failed: #{ $credit->id } - { $e->getMessage() }');
            }
        }
    }

    public function clients()
    {
        $clients = DB::connection('invoice')->select('
            SELECT c.id, cs.first_name, cs.last_name, cs.email,
            c.address1, c.address2, c.city, c.state, c.postal_code,
            c.balance, c.paid_to_date
            FROM clients c
            JOIN contacts cs ON cs.client_id = c.id
        ');
        foreach ($clients as $client) {
            $getClient = Client::find($client->id);
            $user = DB::connection('monitorbase')->select(
                'select * from users where email=?',
                [$client->email]
            );
            $crmId = 0;
            $active = 0;
            $paid = $client->paid_to_date;
            if (is_null($paid)) {
                $paid = 0;
            }
            $balance = $client->balance;
            if (is_null($balance)) {
                $balance = 0;
            }
            if (!is_null($getClient)) {
                if (!empty($user)) {
                    $getClient->crm_id = $user[0]->id;
                    $getClient->active = $user[0]->active;
                    $getClient->balance = $balance;
                    $getClient->total_paid = $paid;
                    $getClient->save();
                    if ($user[0]->auth_id != '') {
                        ClientToken::updateOrCreate([
                            'client_id' => $getClient->id,
                            'token' => $user[0]->auth_id
                        ]);
                    }
                }
                continue;
            }
            
            try {
                if (!empty($user)) {
                    $crmId = $user[0]->id;
                    $active = $user[0]->active;
                }
                Client::create([
                    'id' => $client->id,
                    'name' => $client->first_name . ' ' . $client->last_name,
                    'email' => $client->email,
                    'address' => $client->address1,
                    'address2' => $client->address2,
                    'city' => $client->city,
                    'state' => $client->state,
                    'zipcode' => $client->postal_code,
                    'balance' => $balance,
                    'total_paid' => $paid,
                    'crm_id' => $crmId,
                    'active' => $active
                ]);
            } catch (\Exception $e) {
                info('Client failed: #' . $client->id . ' - ' . $e->getMessage());
                $this->info('Client failed: #' . $client->id . ' - ' . $e->getMessage());
            }
        }
    }

    public function invoices()
    {
        $invoices = DB::connection('invoice')->select('
            select * from invoices where deleted_at is null
        ');
        foreach ($invoices as $invoice) {
            $status = $invoice->invoice_status_id;
            if ($status == 4 || $status == 5) {
                $status = 2;
            }
            $id = (int) $invoice->invoice_number;
            if ($id == 0) {
                continue;
            }
            try {
                Invoice::updateOrCreate(
                    ['id' => $invoice->invoice_number],
                    [
                        'client_id' => $invoice->client_id,
                        'balance' => $invoice->balance,
                        'amount' => $invoice->amount,
                        'due_date' => $invoice->due_date,
                        'invoice_date' => $invoice->invoice_date,
                        'private_notes' => $invoice->private_notes,
                        'public_notes' => $invoice->public_notes,
                        'invoice_status_id' => $status
                    ]
                );
            } catch (\Exception $e) {
                info('Invoice failed: #' . $invoice->id . ' - ' . $e->getMessage());
                $this->info('Invoice failed: #' . $invoice->id . ' - ' . $e->getMessage());
            }
        }
    }

    public function invoiceItems()
    {
        $items = DB::connection('invoice')->select('
            SELECT invoice_number, product_key, notes, cost, qty, it.id  FROM invoice_items it
            JOIN invoices i ON i.id = it.invoice_id
        ');
        foreach ($items as $item) {
            $product = Product::firstOrCreate([
                'name' => $item->product_key,
                'notes' => $item->notes,
                'unit_price' => $item->cost,
                'cost' => 0
            ]);
            try {
                InvoiceItem::updateOrCreate([
                    'invoice_id' => $item->invoice_number,
                    'product_id' => $product->id,
                    'quantity' => $item->qty,
                    'unit_price' => $item->cost,
                    'quantity' => $item->qty,
                    'name' => $item->product_key,
                    'description' => $item->notes
                ]);
            } catch (\Exception $e) {
                info('Invoice Item failed: #' . $item->id . ' - ' . $e->getMessage());
                $this->info('Invoice Item failed: #' . $item->id . ' - ' . $e->getMessage());
            }
        }
    }

    public function payments()
    {
        $payments = DB::connection('invoice')->select('
            SELECT it.id, invoice_number, it.client_id, it.amount, payment_type_id,
            it.payment_date, it.created_at, it.transaction_reference
            FROM payments it
            JOIN invoices i ON i.id = it.invoice_id
            WHERE it.is_deleted=0;
        ');
        foreach ($payments as $payment) {
            $refunded = 0;
            if ($payment->payment_type_id == 6) {
                $refunded = 0;
            }
            if ($payment->payment_date == '0000-00-00') {
                continue;
            }
            $type = 3;
            if ($payment->payment_type_id == 1) {
                $type = 2;
            } elseif ($payment->payment_type_id == 5) {
                $type = 4;
            } elseif ($payment->payment_type_id == 16) {
                $type = 1;
            } elseif ($payment->payment_type_id == 3) {
                $type = 0;
            }
            try {
                Payment::create([
                    'invoice_id' => $payment->invoice_number,
                    'client_id' => $payment->client_id,
                    'amount' => $payment->amount,
                    'refunded' => $refunded,
                    'payment_at' => $payment->payment_date,
                    'id' => $payment->id,
                    'payment_type' => $type,
                    'auth_code' => $payment->transaction_reference
                ]);
            } catch (\Exception $e) {
                info('Payment failed: #' . $payment->id . ' - ' . $e->getMessage());
                $this->info('Payment failed: #' . $payment->id . ' - ' . $e->getMessage());
            }
        }
    }
}
