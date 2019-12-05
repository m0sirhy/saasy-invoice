<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Mail;
use App\Mail\UserInvite;
use Auth;

class UserController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('settings.users.index')
            ->with('users', $users);
    }

    public function show(User $user)
    {
        return view('settings.users.show')
            ->with('user', $user);
    }

    public function create()
    {
        return view('settings.users.create');
    }

    public function update(User $user, Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);
        $user->update($request->all());
        if (isset($request->activate) && $request->activate == 1) {
            $user->token = '';
            $user->save();
            Auth::login($user);
            return redirect()->route('dashboard');
        }
        return redirect()->route('users');
    }

    public function save(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(md5(rand(1000, 5000))),
            'token' => md5(rand(1000, 5000))
        ]);
        Mail::to($request->email)
            ->send(new UserInvite($user->token));
        return redirect()->route('users');
    }

    public function activate($token)
    {
        $user = User::where('token', $token)->first();
        if (is_null($user)) {
            abort(404);
        }
        return view('settings.users.activate')
            ->with('user', $user);
    }
}
