<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use App\Invoice;
use App\Payment;
use App\Product;
use App\Setting;
use App\InvoiceItem;
use App\InvoiceStatus;
use Illuminate\Http\Request;
use App\Events\InvoiceViewed;
use App\Events\InvoiceDeleted;
use App\WireTables\InvoicesWireTable;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InvoicesWireTable $wiretable)
    {
        return $wiretable->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoices.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return view('invoices.show')
            ->with('invoice', $invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        event(new InvoiceViewed($invoice));

        return view('invoices.edit')
            ->with('invoice', $invoice)
            ->with('invoiceStatuses', InvoiceStatus::get())
            ->with('types', Payment::TYPES);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        event(new InvoiceDeleted($invoice));
        $invoice->delete();
        return redirect()->route('invoices');
    }

    public function download(Invoice $invoice)
    {
        $data['data'] = $invoice;
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
