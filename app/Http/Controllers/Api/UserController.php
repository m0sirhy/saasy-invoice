<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function getAll()
    {
        $clients = User::orderBy('name')->get();
        return response()->json($clients);
    }
}
