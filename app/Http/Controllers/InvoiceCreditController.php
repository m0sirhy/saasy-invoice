<?php

namespace App\Http\Controllers;

use App\InvoiceCredit;
use Illuminate\Http\Request;
use App\DataTables\InvoiceCreditsDataTable;

class InvoiceCreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InvoiceCreditsDataTable $dataTable)
    {
        return $dataTable->render('invoiceCredits.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InvoiceCredit  $invoiceCredit
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceCredit $invoiceCredit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvoiceCredit  $invoiceCredit
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceCredit $invoiceCredit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvoiceCredit  $invoiceCredit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceCredit $invoiceCredit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InvoiceCredit  $invoiceCredit
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceCredit $invoiceCredit)
    {
        //
    }
}
