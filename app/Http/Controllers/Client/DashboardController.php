<?php

namespace App\Http\Controllers\Client;

use PDF;
use Auth;
use stdClass;
use App\Invoice;
use App\Payment;
use App\ClientToken;
use App\Subscription;
use App\Helpers\AuthNet;
use App\Events\PaymentAdded;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\ClientDashboardDataTable;

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
        if ($invoice->client_id !== Auth::user()->id) {
            abort(413);
        }
        if ($invoice->invoice_status_id < VIEWED) {
            $invoice->invoice_status_id = VIEWED;
            $invoice->save();
        }
        return view('clients.portal.show')
            ->with('invoice', $invoice);
    }

    public function downloadInvoice(Invoice $invoice)
    {
        if ($invoice->client_id !== Auth::user()->id) {
            abort(413);
        }
        $data['data'] = $invoice;
        $pdf = PDF::loadView('clients.portal.invoice', $data);
        return $pdf->download('Invoice-#' . $invoice->id . '.pdf');
    }

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
            return redirect()->route('client.dashboard')->withSuccess('Payment successful');
        }
        return redirect()-back()->withError('We are unable to process your payment.');
    }
}
