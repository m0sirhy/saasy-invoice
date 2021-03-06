<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoice;
use App\Payment;
use App\PaymentGateway;
use App\Helpers\AuthNet;
use App\Events\PaymentAdded;
use Illuminate\Http\Request;
use App\Helpers\ButtonHelper;
use App\PaymentGatewaySetting;
use App\Events\PaymentOneTime;
use App\Events\PaymentRefunded;
use App\WireTables\PaymentsWireTable;

class PaymentController extends Controller
{
    /**
     * Show the Payments
     *
     * @return [type] [description]
     */
    public function index(PaymentsWireTable $wiretable)
    {
        return $wiretable->render();
    }

    public function create()
    {
        return view('payments.create')
            ->with('types', Payment::TYPES);
    }

    public function addPayment(Request $request, Invoice $invoice)
    {
        Payment::create([
            'invoice_id' => $invoice->id,
            'client_id' => $invoice->client_id,
            'amount' => $request->amount,
            'refunded' => '0',
            'auth_code' => $request->auth_code,
            'payment_type' => $request->payment_type,
            'payment_at' => $request->payment_at,
            'transaction_id' => ''
        ]);
        event(new PaymentAdded($invoice, $request->amount));
        return redirect()->back()->withSuccess('Payment Added');
    }

    public function userCharge(Invoice $invoice)
    {
        $client = $invoice->Client;
        $cardData = null;
        if (!is_null($client) && !is_null($client->ClientToken)) {
            $cardData = AuthNet::getCardData($client->ClientToken->token);
        }
        return view('payments.charge')
            ->with('invoice', $invoice)
            ->with('cardData', $cardData);
    }

    public function chargeCard(Request $request, Invoice $invoice)
    {
        if (!is_null($invoice->id)) {
            $new = null;

            if (is_null($invoice->Client->clientToken)) {
                $new = 1;
                $name = explode(' ', $invoice->Client->name, 2);
                $params = AuthNet::setParams($request, $invoice, $name);
                $token = AuthNet::createCustomer($params);
                if (is_array($token)) {
                    return AuthNet::checkError($token, AuthNet::creationErrorMessage());
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
            if (is_null($new) && isset($request->all()['updated']) && $request->all()['updated'] == 1) {
                $name = explode(' ', $invoice->Client->name, 2);
                $params = AuthNet::setParams($request, $invoice, $name);
                $data = AuthNet::deleteAndUpdateCard($token, $paymentProfile, $params);
                if (is_array($data)) {
                    return AuthNet::checkErrors($data, AuthNet::updateErrorMessage());
                }
            }
            $id = $invoice->id;
            $amount = $request->amount;
            $payment = AuthNet::chargeProfile($token, $paymentProfile, $amount, $id);
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
                return redirect()->route('payments')->withSuccess('Payment successful');
            }
            if (!is_null($payment->getResultCode())) {
                $code = $payment->getResultCode();
                $message = 'Please contact ' . $setting->email . ' with transaction response code ' . $code;
                return redirect()->back()->withError('We were unable to process your payment. ' . $message . '.');
            }
            return redirect()->back()->withError('We are unable to process your payment.');
        }
        $name = explode(' ', $request->name, 2);
        $params = AuthNet::setParamsSingle($request, $name);
        $payment = AuthNet::chargeCard($params);
        if (!is_null($payment->getResultCode()) && $payment->getResultCode() == 1) {
            dd('got here!');
            $reference = json_decode($payment->getTransactionReference())->transId;
            $receipt = Payment::create([
                'invoice_id' => '0',
                'client_id' => '0',
                'amount' => $request->amount,
                'refunded' => '0',
                'auth_code' => $payment->getAuthorizationCode(),
                'payment_type' => 3,
                'payment_at' => now(),
                'transaction_id' => $reference,
            ]);
            event(new PaymentOneTime($receipt, $request->email));
            return redirect()->route('payments.user.card')->withSuccess('Payment successful');
        }
        return redirect()->back()->withError('We are unable to process your payment.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $invoices = Invoice::get()
            ->where('client_id', $payment->client_id)
            ->pluck('id')
            ->toArray();
        $payment->payment_at = $payment->payment_at->format('Y-m-d');
        return view('payments.edit')
            ->with('payment', $payment)
            ->with('types', Payment::TYPES)
            ->with('invoices', $invoices);
    }

    /**
     * Show the payment settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $paymentGateways = PaymentGateway::get();
        $activeGateway = PaymentGateway::where('active', 1)
            ->first();
        $paymentGatewaySetting = PaymentGatewaySetting::where('payment_gateway_id', $activeGateway->id)
            ->first();
        return view('settings.payment.index')
            ->with('paymentGateways', $paymentGateways)
            ->with('activeGateway', $activeGateway)
            ->with('paymentGatewaySetting', $paymentGatewaySetting);
    }

    public function settingsSave(Request $request)
    {
        $activeGateway = PaymentGateway::where('active', 1)
            ->first();
        PaymentGatewaySetting::updateOrCreate(
            ['payment_gateway_id' => $activeGateway->id],
            $request->all()
        );
        return redirect()->route('settings.payment');
    }

    public function refund(Payment $payment)
    {
        $payment->Client->load('ClientToken');
        if ($payment->payment_type == 3) {
            $token = $payment->Client->ClientToken->token;
            $response = AuthNet::refund($payment->transaction_id, $payment->amount, $token);
            if (!$response->isSuccessful()) {
                return redirect()->back()->withError('Refund not processed');
            }
        }
        $payment->refunded = 1;
        $payment->save();
        event(new PaymentRefunded($payment));
        return redirect()->route('payments');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments');
    }

    public function downloadExcel($sortField = 'id', $sortAsc = 'desc', $search = '')
    {
        return ButtonHelper::createExcel('payments', $sortField, $sortAsc, $search);
    }
}
