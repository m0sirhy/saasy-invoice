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
    	$invoice = Invoice::create([
    		'client_id' => $request->client,
    		'invoice_status_id' => $request->status,
    		'balance' => $request->total,
    		'amount' => $request->total,
    		'due_date' => $request->due_date,
    		'invoice_date' => $request->invoice_date,
    		'start_date' => $request->start_date,
    		'end_date' => $request->end_date,
    		'public_id' => 5
    	]);
    	foreach ($request->items as $item) {
	    	InvoiceItem::create([
	    		'invoice_id' => $invoice['id'],
	    		'quantity' => $item['quantity'],
	    		'product_id' => $item['product_id'],
	    		'description' => $item['description']
	    	]);
    	}
    	
    	return response()->json([
            'status' => 200
        ]);
    }
}
