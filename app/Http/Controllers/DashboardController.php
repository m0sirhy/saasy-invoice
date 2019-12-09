<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = \App\Client::count();
        $newClients = \App\Client::where('created_at', '>=', now()->subDay())->count();
        return view('dashboard')
            ->with('clients', $clients)
            ->with('newClients', $newClients);
    }
}
