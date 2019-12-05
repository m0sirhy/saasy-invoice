<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\PaymentGateway;
use App\PaymentGatewaySetting;
use App\DataTables\PaymentsDataTable;

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

    public function show(Payment $payment)
    {
        return view('payments.show')
            ->with('payment', $payment);
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
