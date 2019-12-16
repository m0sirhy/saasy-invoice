<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Invoice;
use App\InvoiceItem;
use App\InvoiceStatus;
use App\Client;
use App\Product;
use Log;

class InvoiceController extends Controller
{
    public function create(Request $request)
    {
    	$invoice = Invoice::updateOrCreate([
            $request->all(),
            'amount' => $request->total,
            'balance' => $request->total
        ]);
    	foreach ($request->items as $item) {
	    	InvoiceItem::create([$item]);
    	}
    	
    	return response()->json([
            'status' => 200,
            'data' => $request->id
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $invoice->update($request->all());
        foreach ($request->items as $item) {
            InvoiceItem::updateOrCreate(
                ['id' => $item['id'], 'invoice_id' => $invoice->id],
                $item
            );
        }
        return response()->json([
            'status' => 200
        ]);
    }

    public function destroy(Invoice $invoice)
    {
        InvoiceItem::where('invoice_id', $invoice->id)->delete();
        $invoice->delete();
        return redirect()->route('invoices');
    }
}
