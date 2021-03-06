<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Invoice;
use App\Payment;
use App\Helpers\AuthNet;
use App\Events\InvoiceCreated as IC;
use App\Events\PaymentAdded;
use App\UserActivityLog;

class InvoiceCreated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends unsent invoices that are set to queue';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $billed = 0;
        Invoice::with(['Client' => function ($query) {
                $query->with('ClientToken');
        }])
            ->where('amount', '>', 0)
            ->where('queue', 1)
            ->each(function ($invoice) use (&$billed) {
                event(new IC($invoice, 1));
                $invoice->queue = 0;
                $invoice->save();
                if ($invoice->balance > 0 && !is_null($invoice->Client->ClientToken)) {
                    $token = $invoice->Client->ClientToken->token;
                    $paymentProfile = AuthNet::getPayment($token);
                    if (is_array($paymentProfile)) {
                        $message = ' - Failed To Get Payment Profile For invoice #' . $invoice->id;
                        $invoice->private_notes = $invoice->private_notes . $message . ' ' . now()->format('Y-m-d H:i:s');
                        $invoice->save();
                        return;
                    }
                    $id = $invoice->id;
                    $amount = $invoice->balance;
                    $payment = AuthNet::chargeProfile($token, $paymentProfile, $amount, $id);
                    $resultCode = $payment->getResultCode();
                    $invoice->queue = 0;
                    $invoice->save();
                    if (!is_null($resultCode) && $resultCode == 1) {
                        $reference = json_decode($payment->getTransactionReference())->transId;
                        Payment::create([
                            'invoice_id' => $invoice->id,
                            'client_id' => $invoice->client_id,
                            'amount' => $invoice->amount,
                            'refunded' => '0',
                            'auth_code' => $payment->getAuthorizationCode(),
                            'payment_type' => 3,
                            'payment_at' => now(),
                            'transaction_id' => $reference,
                        ]);
                        $billed += $invoice->amount;
                        $this->info($billed);
                        event(new PaymentAdded($invoice, $amount));
                        $userId = 9999999;
                        UserActivityLog::create([
                            'message' => 'created payment',
                            'user_id' => $userId,
                            'invoice_id' => $invoice->id
                        ]);
                        $invoice->invoice_status_id = PAID;
                        $invoice->save();
                        return;
                    }
                    $message = ' - Unable to process payment for Invoice #' . $invoice->id;
                    $invoice->private_notes = $invoice->private_notes . $message;
                    $invoice->save();
                    return;
                }
            });
    }
}
