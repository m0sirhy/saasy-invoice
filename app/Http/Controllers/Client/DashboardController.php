<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\DataTables\ClientDashboardDataTable;
use Illuminate\Http\Request;
use App\Subscription;
use App\Invoice;
use App\ClientToken;
use App\Payment;
use App\Helpers\AuthNet;
use PDF;
use Auth;
use App\Events\PaymentAdded;
use stdClass;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:client')->except('logout');
    }

    public function index(ClientDashboardDataTable $dataTable)
    {
        $client = Auth::user();
        $invoices = Invoice::where('client_id', $client->id)
            ->with('InvoiceStatus')
            ->with('Items')
            ->get();
        $total = Invoice::where('client_id', $client->id)
            ->sum('amount');
        $balance = Invoice::where('client_id', $client->id)
            ->sum('balance');
        $paid = $total-$balance;
        $subscription = json_encode(Subscription::where('client_id', $client->id)->first());
        $data = new stdClass();
        $data->total = $total;
        $data->balance = $balance;
        $data->paid = $paid;
        $data->subscription = $subscription;
        return $dataTable->with('client', $client)->render('clients.portal.dashboard', compact('data', $data));
    }

    public function showInvoice(Invoice $invoice)
    {
        if ($invoice->invoice_status_id < 3) {
            $invoice->invoice_status_id = 3;
            $invoice->save();
        }
        return view('clients.portal.show')
            ->with('invoice', $invoice);
    }

    public function downloadInvoice(Invoice $invoice)
    {
        $data['data'] = $invoice;
        $pdf = PDF::loadView('clients.portal.invoice', $data);
        return $pdf->download('Invoice-#' . $invoice->id . '.pdf');
    }

    public function payInvoice(Invoice $invoice)
    {
        return view('clients.portal.pay')
            ->with('invoice', $invoice);
    }

    public function payment(Request $request, Invoice $invoice) {
        if (is_null($invoice->Client->ClientToken)) {
            $name = explode(' ', $invoice->Client->name , 2);
            $params = [
                'card' => [
                    'billingFirstName' => $name[0],
                    'billingLastName' => $name[1],
                    'billingAddress1' => $invoice->Client->address,
                    'billingCity' => $invoice->Client->city,
                    'billingState' => $invoice->Client->state,
                    'billingPostcode' => $invoice->Client->zipcode,
                    'billingPhone' => '',
                ],
                'opaqueDataDescriptor' => $request->dataDescriptor,
                'opaqueDataValue' => $request->dataValue,
                'name' => $request->name,
                'email' => $invoice->Client->email,
                'customerType' => 'individual',
                'customerId' => $invoice->Client->crm_id,
                'description' => 'MEMBER ID ' . $invoice->client_id,
                'forceCardUpdate' => true
            ];             
            $token = AuthNet::createCustomer($params);
            $invoice->Client->ClientToken = ClientToken::create([
                'client_id' => $invoice->client_id,
                'token' => $token
            ]);
        }
        $token = $invoice->Client->ClientToken->token;
        $paymentProfile = AuthNet::getPayment($token);
        $payment = AuthNet::chargeProfile($token, $paymentProfile, $request->amount, $invoice->id);
        if (!is_null($payment->transactionResponse->responseCode) && $payment->transactionResponse->responseCode == 1) {
            Payment::create([
                'invoice_id' => $invoice->id,
                'client_id' => $invoice->client_id,
                'amount' => $request->amount,
                'refunded' => '0',
                'auth_code' => $payment->transactionResponse->authCode,
                'payment_type' => 'Credit Card',
                'payment_at' => now(),
                'transaction_id' => $payment->transactionResponse->transId
            ]);
            event(new PaymentAdded($invoice, $request->amount));
            return redirect()->route('client.dashboard')->with('message', 'Payment successful');
        }
        return redirect()-back()->with('errors', 'We are unable to process your payment.');
    }
}
