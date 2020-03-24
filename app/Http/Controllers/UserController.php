<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Mail;
use App\User;
use App\Mail\UserCreate;
use App\Mail\UserInvite;
use Illuminate\Http\Request;

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

    /**
     * Show a user
     *
     * @param User $user
     * @return view
     */
    public function show(User $user)
    {
        return view('settings.users.show')
            ->with('user', $user);
    }

    /**
     * Create a new user
     *
     * @return view
     */
    public function create()
    {
        return view('settings.users.create');
    }

    /**
     * Update a user
     *
     * @param User $user
     * @param Request $request
     * @return redirect
     */
    public function update(User $user, Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);
        $user->update($request->all());
        if (isset($request->activate) && $request->activate == 1) {
            $user->token = '';
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::login($user);
            Mail::to($user->email)
                ->send(new UserCreated($user));
            return redirect()
                ->route('dashboard')
                ->withSuccess('Welcome!');
        }
        return redirect()->route('users');
    }

    /**
     * Save a user
     *
     * @param Request $request
     * @return redirect
     */
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

    /**
     * Activate a user
     *
     * @param stromg $token
     * @return view
     */
    public function activate($token)
    {
        $user = User::where('token', $token)->first();
        if (is_null($user) || $token = '') {
            redirect()->route('dashboard')->withError('Token expired or invalid.');
        }
        return view('settings.users.activate')
            ->with('user', $user);
    }
}
