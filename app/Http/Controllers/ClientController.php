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
}
