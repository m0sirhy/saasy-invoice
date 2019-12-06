<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function getAll(Request $request)
    {
    	$clients = Client::all();
    	return response()->json($clients);
    }
}
