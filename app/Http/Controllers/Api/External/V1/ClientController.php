<?php

namespace App\Http\Controllers\Api\External\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function create(Request $request)
    {
        $client = Client::create($request->all());
        return response()->json($client);
    }

    public function getAll(Request $request)
    {
        $clients = Client::limit(5)->get();
        return response()->json($clients);
    }

    public function show(Client $client)
    {
        return response()->json($client);
    }

    public function showCrm($crmId)
    {
        $client = Client::where('crm_id', $crmId)->first();
        return response()->json($client);
    }
}
