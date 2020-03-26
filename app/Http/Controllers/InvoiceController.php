<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Client;
use App\Product;
use App\InvoiceItem;
use Illuminate\Http\Request;
use App\Events\InvoiceDeleted;
use App\Events\InvoiceViewed;
use App\DataTables\InvoicesDataTable;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InvoicesDataTable $dataTable)
    {
        return $dataTable->render('invoices.index');
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
        $items = InvoiceItem::where('invoice_id', $invoice->id)->get()->toArray();
        event(new InvoiceViewed($invoice));
        $invoice = $invoice->toArray();
        $invoice['invoice_date'] = date('Y-m-d', strtotime($invoice['invoice_date']));
        return view('invoices.edit')
            ->with('invoice', $invoice)
            ->with('items', $items);
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
}
