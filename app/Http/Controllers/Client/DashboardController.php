<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\DataTables\InvoicesDataTable;
use Illuminate\Http\Request;
use App\Subscription;
use App\Invoice;
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
}
