<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\DataTables\ClientsDataTable;

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

    public function show(Client $client)
    {
        return view('clients.show')
            ->with('client', $client);
    }
}
