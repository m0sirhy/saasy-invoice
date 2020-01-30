<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserActivityLog;
use Auth;

class UserActivityController extends Controller
{
    public function index() {
    	// dd(UserActivityLog::where('user_id', Auth::id())->get()->toArray());
    	return UserActivityLog::where('user_id', Auth::id())->get()->toArray();
    }
}
