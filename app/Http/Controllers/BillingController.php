<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Client;
use App\Product;
use App\BillingItem;
use Illuminate\Http\Request;
use App\DataTables\BillingsDataTable;
use Log;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BillingsDataTable $dataTable)
    {
        return $dataTable->render('billings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('billings.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function show(Billing $billing)
    {
        return view('billings.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function edit(Billing $billing)
    {
        $items = BillingItem::where('billing_id', $billing->id)->get()->toArray();
        foreach($items as &$item) {
            $item['unit_price'] = $item['price_per'];
            unset($item['price_per']);
        }
        return view('billings.edit')
            ->with('billing', $billing->toArray())
            ->with('items', $items);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Billing $billing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Billing $billing)
    {
        BillingItem::where('billing_id', $billing->id)->delete();
        $billing->delete();
        return redirect()->route('billings');
    }
}
