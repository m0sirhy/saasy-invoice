<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\DataTables\InvoicesDataTable;
use Illuminate\Http\Request;
use App\Subscription;
use App\Invoice;
use App\ClientToken;
use App\Helpers\AuthNet;
use PDF;
use Auth;

class DashboardController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:client')->except('logout');
    }

    public function index()
    {
    	$client = Auth::user();

    	$invoices = Invoice::where('client_id', $client->id)
	    	->with('InvoiceStatus')
	    	->with('Items')
	    	->get();
        $subscription = Subscription::where('client_id', $client->id)->first();
    	return view('clients.portal.dashboard')
            ->with('invoices', $invoices)
            ->with('subscription', $subscription);
    }

    public function showInvoice(Invoice $invoice)
    {
        if($invoice->invoice_status_id < 3) {
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
        $paymentProfile = AuthNet::getPayment($invoice->Client->ClientToken->token);
        dd($paymentProfile);
    }
}
