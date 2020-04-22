<?php

namespace App\Http\Controllers\Client;

use Auth;
use App\Invoice;
use App\Payment;
use App\ClientToken;
use App\Helpers\AuthNet;
use App\Events\PaymentAdded;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function payInvoice(Invoice $invoice)
    {
        $client = Auth::user();
        $cardData = null;
        if (!is_null($client->clientToken)) {
            $cardData = AuthNet::getCardData($client->ClientToken->token);
        }
        return view('clients.portal.pay')
            ->with('invoice', $invoice)
            ->with('cardData', $cardData);
    }

    public function paymentFile(Request $request, Invoice $invoice)
    {
        $token = $invoice->Client->ClientToken->token;
        $paymentProfile = AuthNet::getPayment($token);
        return $this->chargeProfile($token, $paymentProfile, $request, $invoice);
    }

    public function chargeProfile($token, $paymentProfile, $request, $invoice)
    {
        $payment = AuthNet::chargeProfile($token, $paymentProfile, $request->amount, $invoice->id);
        if (!is_null($payment->transactionResponse->responseCode) && $payment->transactionResponse->responseCode == 1) {
            Payment::create([
                'invoice_id' => $invoice->id,
                'client_id' => $invoice->client_id,
                'amount' => $request->amount,
                'refunded' => '0',
                'auth_code' => $payment->transactionResponse->authCode,
                'payment_type' => 3,
                'payment_at' => now(),
                'transaction_id' => $payment->transactionResponse->transId
            ]);
            event(new PaymentAdded($invoice, $request->amount));
            return redirect()->route('client.dashboard')->withSuccess('Payment successful');
        }
        return redirect()-back()->withError('We are unable to process your payment.');
    }

    public function payment(Request $request, Invoice $invoice)
    {
        if (is_null($invoice->Client->ClientToken)) {
            $name = explode(' ', $invoice->Client->name, 2);
            $params = AuthNet::setParams($request, $invoice, $name);
            $token = AuthNet::createCustomer($params);
            $invoice->Client->ClientToken = ClientToken::create([
                'client_id' => $invoice->client_id,
                'token' => $token
            ]);
        }
        $token = $invoice->Client->ClientToken->token;
        $paymentProfile = AuthNet::getPayment($token);
        if (is_null($paymentProfile)) {
            return redirect()->back()->with('message', 'Something went wrong getting your payment profile.');
        }
        if (isset($request->all()['updated']) && $request->all()['updated'] == 1) {
            $name = explode(' ', $invoice->Client->name, 2);
            $params = AuthNet::setParams($request, $invoice, $name);
            $response = AuthNet::deleteAndUpdateCard($token, $paymentProfile, $params);
            if ($response == 'Error') {
                return redirect()->back()->with('errors', 'We were unable to process your updated card information.');
            }
        }
        return $this->chargeProfile();
    }
}
