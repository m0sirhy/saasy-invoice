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
		return view('clients.new');
	}

	public function save(Request $request)
	{
		Client::create($request->all());
		return redirect()->route('clients');
	}

	public function view(Client $client)
	{
		return view('clients.view')
			->with('client', $client);
	}
