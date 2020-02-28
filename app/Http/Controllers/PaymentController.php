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
    public function index(PaymentsDataTable $dataTable)
    {
        return $dataTable->render('payments.index');
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
        // $gateway = Omnipay::create('AuthorizeNet_CIM');
        // $gateway->setApiLoginId("4pQKd386");
        // $gateway->setTransactionKey('7WS3x54w53PR2Vfu');
        // $gateway->setDeveloperMode(true);

        // $rrr = $gateway->purchase(
        //     [
        //         'notifyUrl' => 'https://www.monitorbase.com',
        //         'amount' => 5,
        //         'opaqueDataDescriptor' => $request->dataDescriptor,
        //         'opaqueDataValue' => $request->dataValue,
        //     ]
        // );
        // dump($rrr);
        // $gateway = Omnipay::create('AuthorizeNet_CIM');
        // $gateway->setApiLoginId("6Ux8Sw4m");
        // $gateway->setTransactionKey('2r5Xx43dB3Kc4N6K');
        // $gateway->setDeveloperMode(false);
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
}
