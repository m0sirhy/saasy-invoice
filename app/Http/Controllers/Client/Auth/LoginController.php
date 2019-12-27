<?php

namespace App\Http\Controllers\Client\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Client;

class LoginController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:client')->except('logout');
    }
    /**
     * Login the client.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login($uuid)
    {
        $client = Client::where('uuid', $uuid)->first();
	    if(!is_null($client) && Auth::guard('client')->login($client)) {
	        return redirect()->route('client.home');
	    }
	    return $this->loginFailed();
    }
    /**
     * Logout the client.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
      	Auth::guard('client')->logout();
    	return redirect()
        	->route('client.login')
        	->with('status','Client has been logged out!');
    }
    /**
     * Redirect back after a failed login.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed()
    {
    	return redirect()
	        ->back()
	        ->withInput()
	        ->with('error','Login failed, please try again!');
    }
}
