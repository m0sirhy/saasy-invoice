<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\DataTables\ClientsDataTable;
use App\DataTables\ClientInvoicesDataTable;
use App\DataTables\ClientPaymentsDataTable;
use App\DataTables\ClientCreditsDataTable;
use App\Invoice;

class ClientController extends Controller
{
    public function index(ClientsDataTable $dataTable)
    {
        return $dataTable->render('clients.index');
    }

    public function create()
    {
        return view('clients.create');
    }

    public function save(Request $request)
    {
        Client::create($request->all());
        return redirect()->route('clients');
    }

    // public function show(Client $client)
    // {
    //     return view('clients.invoices')
    //         ->with('client', $client);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function invoicesShow(Client $client, ClientInvoicesDataTable $dataTable)
    {
        return $dataTable->with('client', $client)->render('clients.invoices', compact('client', $client));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paymentsShow(Client $client, ClientPaymentsDataTable $dataTable)
    {
        return $dataTable->with('client', $client)->render('clients.payments', compact('client', $client));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function creditsShow(Client $client, ClientCreditsDataTable $dataTable)
    {
        return $dataTable->with('client', $client)->render('clients.credits', compact('client', $client));
    }
}
