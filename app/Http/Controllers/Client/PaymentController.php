<?php

namespace App\Http\Controllers\Client;

use Auth;
use App\Invoice;
use App\Payment;
use App\Setting;
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
        if (is_array($paymentProfile)) {
            return AuthNet::checkErrors($paymentProfile, AuthNet::profileErrorMessage());
        }
        return $this->chargeProfile($token, $paymentProfile, $request, $invoice);
    }

    public function chargeProfile($token, $paymentProfile, $request, $invoice)
    {
        $payment = AuthNet::chargeProfile($token, $paymentProfile, $request->amount, $invoice->id);
        if (!is_null($payment->getResultCode()) && $payment->getResultCode() == 1) {
            $reference = json_decode($payment->getTransactionReference())->transId;
            Payment::create([
                'invoice_id' => $invoice->id,
                'client_id' => $invoice->client_id,
                'amount' => $request->amount,
                'refunded' => '0',
                'auth_code' => $payment->getAuthorizationCode(),
                'payment_type' => 3,
                'payment_at' => now(),
                'transaction_id' => $reference,
            ]);
            event(new PaymentAdded($invoice, $request->amount));
            return redirect()->route('client.dashboard')->withSuccess('Payment successful');
        }
        $setting = Setting::first();
        if (!is_null($payment->getResultCode())) {
            $code = $payment->getResultCode();
            $message = 'Please contact ' . $setting->email . ' with transaction response code ' . $code;
            return redirect()->back()->withError('We were unable to process your payment. ' . $message . '.');
        }
        return redirect()->back()->withError('We were unable to process your payment.');
    }

    public function payment(Request $request, Invoice $invoice)
    {
        if (is_null($invoice->Client->ClientToken)) {
            $name = explode(' ', $invoice->Client->name, 2);
            $params = AuthNet::setParams($request, $invoice, $name);
            $token = AuthNet::createCustomer($params);
            if (is_array($token)) {
                return AuthNet::checkErrors($token, AuthNet::creationErrorMessage());
            }
            $invoice->Client->ClientToken = ClientToken::create([
                'client_id' => $invoice->client_id,
                'token' => $token
            ]);
        }
        $token = $invoice->Client->ClientToken->token;
        $paymentProfile = AuthNet::getPayment($token);
        if (is_array($paymentProfile)) {
            return AuthNet::checkErrors($paymentProfile, AuthNet::profileErrorMessage());
        }
        if (isset($request->all()['updated']) && $request->all()['updated'] == 1) {
            $name = explode(' ', $invoice->Client->name, 2);
            $params = AuthNet::setParams($request, $invoice, $name);
            $data = AuthNet::deleteAndUpdateCard($token, $paymentProfile, $params);
            if (is_array($data)) {
                return AuthNet::checkErrors($data, AuthNet::updateErrorMessage());
            }
        }
        return $this->chargeProfile($token, $paymentProfile, $request, $invoice);
    }
}
