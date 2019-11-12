<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::find(1);
        return view('settings.index')
            ->with('setting', $setting);
    }

    public function save(Request $request)
    {
        Setting::updateOrCreate(
            ['id' => 1],
            $request->all()
        );
        return redirect()->route('settings');
    }
}
