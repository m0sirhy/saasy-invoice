<?php

namespace App\Http\Controllers\Api;

use App\Payment;
use App\Invoice;
use App\Events\PaymentAdded;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $payment = Payment::create($request->all());
        $invoice = Invoice::findOrFail($request->invoice_id);
        event(new PaymentAdded($invoice, $payment->amount));
        return response()->json($payment);
    }

    public function getAll(Request $request)
    {
        $payments = Payment::orderBy('name')->get();
        return response()->json($payments);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json('Payment deleted');
    }

    public function show(Payment $payment)
    {
        return response()->json($payment);
    }

    public function showCrm($crmId)
    {
        $payment = Payment::where('crm_id', $crmId)->first();
        return response()->json($payment);
    }

    public function update(Request $request, Payment $payment)
    {
        $payment->update($request->all());
        return response()->json($payment);
    }
}
