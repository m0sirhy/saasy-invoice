<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoggedOutController extends Controller
{
    public function loggedOut()
    {
        return view('clients.portal.logged-out');
    }
}
