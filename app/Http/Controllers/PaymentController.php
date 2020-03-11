<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\PaymentGateway;
use App\PaymentGatewaySetting;
use App\DataTables\PaymentsDataTable;
use Omnipay\Common\CreditCard;
use Omnipay\Omnipay;
use App\Helpers\AuthNet;

class PaymentController extends Controller
{
    /**
     * Show the Payments
     *
     * @return [type] [description]
     */
    public function index()
    {
        $payments = Payment::with('client')->orderBy('id', 'desc')->get();
        return view('payments.index', [
            'payments' => $payments
        ]);
    }

    public function create()
    {
        return view('payments.create')
            ->with('types', Payment::TYPES);
    }

    public function userCharge()
    {
        return view('payments.charge');
    }

    public function chargeCard(Request $request)
    {
        $params = [
            'card' => [
                'billingFirstName' => 'Guy',
                'billingLastName' => 'Warner',
                'billingAddress1' => '1131 E Ridgedale Ln',
                'billingCity' => 'Salt Lake City',
                'billingState' => 'UT',
                'billingPostcode' => '84106',
                'billingPhone' => '',
            ],
            'opaqueDataDescriptor' => $request->dataDescriptor,
            'opaqueDataValue' => $request->dataValue,
            'name' => 'Guy',
            'email' => 'warnerdata@gmail.com',
            'customerType' => 'individual',
            'customerId' => '3501',
            'description' => 'MEMBER ID 3501',
            'forceCardUpdate' => true
        ];
        // $card = $gateway->createCard($params);
        // $response = $card->send();
        // $data = $response->getData();
        $token = AuthNet::createCustomer($params);
        info($token);
        $payment = AuthNet::getPayment($token);
        info($payment);
        $charge = AuthNet::chargeProfile($token, $payment, .50, 123);
        dd($charge);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        return view('payments.edit')
            ->with('payment', $payment)
            ->with('types', Payment::TYPES);
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
        if ($payment->payment_type == 'Credit Card') {
            $token = $payment->Client->ClientToken->token;
            $response = AuthNet::refund($payment->transaction_id, $payment->amount, $token);
            if (!$response->isSuccessful()) {
                return redirect()->back()->withError('Refund not processed');
            }
        }
        $payment->refunded = 1;
        $payment->save();
        return redirect()->route('payments');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments');
    }
}
