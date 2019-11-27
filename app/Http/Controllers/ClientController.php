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

	/**
     * Show the form for creating a new client.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        return view('clients.new');
    }
}
