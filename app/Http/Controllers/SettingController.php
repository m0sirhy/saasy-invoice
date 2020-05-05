<?php

namespace App\Http\Controllers;

use App\Client;
use App\Credit;
use App\Billing;
use App\Invoice;
use App\Payment;
use App\Product;
use App\Setting;
use App\BillingItem;
use App\ClientToken;
use App\InvoiceItem;
use App\Subscription;
use App\UserActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    /**
     * Save the settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        if (!isset($request->auto_credits)) {
            $request->auto_credits = 0;
        }
        Setting::updateOrCreate(
            ['id' => 1],
            $request->all()
        );
        return redirect()->route('settings');
    }

    /**
     * Show the danger page
     *
     * @return \Illuminate\Http\Response
     */
    public function danger()
    {
        return view('settings.danger');
    }

    /**
     * Show the reminder settings page
     *
     * @return \Illuminate\Http\Response
     */
    public function remindersSettings()
    {
        return view('settings.invoices.reminder')
            ->with('setting', Setting::find('1'));
    }

    /**
     * Save reminder settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remindersSave(Request $request)
    {
        $temp = $request->all();
        if (!isset($request->remind_enable1)) {
            $temp['remind_enable1'] = 0;
        }
        if (!isset($request->remind_enable2)) {
            $temp['remind_enable2'] = 0;
        }
        if (!isset($request->remind_enable3)) {
            $temp['remind_enable3'] = 0;
        }
        unset($temp['_token']);
        Setting::where('id', 1)
            ->update($temp);
        return redirect()->route('settings');
    }

    /**
     * Remove all information from the site
     *
     * @return void
     */
    public function delete()
    {
        Billing::truncate();
        BillingItem::truncate();
        Client::truncate();
        ClientToken::truncate();
        Credit::truncate();
        Invoice::truncate();
        InvoiceItem::truncate();
        Payment::truncate();
        Product::truncate();
        Subscription::truncate();
        UserActivityLog::truncate();
        return redirect()->route('dashboard')->withSuccess('Data reset!');
    }
}
