<?php

namespace App\Http\Controllers\Client;

use Auth;
use stdClass;
use App\Invoice;
use App\Subscription;
use App\Http\Controllers\Controller;
use App\DataTables\ClientDashboardDataTable;

class DashboardController extends Controller
{
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
}
