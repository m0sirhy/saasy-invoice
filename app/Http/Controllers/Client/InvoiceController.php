<?php

namespace App\Http\Controllers\Client;

use PDF;
use Auth;
use App\Invoice;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Client\ClientInvoiceViewed;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        if ($invoice->client_id !== Auth::user()->id) {
            abort(413);
        }
        if ($invoice->invoice_status_id < VIEWED) {
            $invoice->invoice_status_id = VIEWED;
            $invoice->save();
        }
        event(new ClientInvoiceViewed($invoice));
        $setting = Setting::select([
                'company',
                'address',
                'address2',
                'city',
                'state',
                'zipcode',
                'phone',
                'email'
            ])->first();
        return view('clients.portal.show')
            ->with('invoice', $invoice)
            ->with('setting', $setting);
    }

    public function download(Invoice $invoice)
    {
        if ($invoice->client_id !== Auth::user()->id) {
            abort(413);
        }
        $setting = Setting::first();
        $data['data'] = $invoice;
        $data['data']['company'] = $setting->company;
        $data['data']['address'] = $setting->address;
        $data['data']['address2'] = $setting->address2;
        $data['data']['city'] = $setting->city;
        $data['data']['state'] = $setting->state;
        $data['data']['zipcode'] = $setting->zipcode;
        $data['data']['phone'] = $setting->phone;
        $data['data']['email'] = $setting->email;
        $pdf = PDF::loadView('clients.portal.invoice', $data);
        return $pdf->download('Invoice-#' . $invoice->id . '.pdf');
    }
}
