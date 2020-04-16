<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\InvoiceItem;
use App\Invoice;

class InvoiceItemsController extends Controller
{
    public function getByInvoice(Invoice $invoice)
    {
        return response()->json(InvoiceItem::where('invoice_id', $invoice->id)->get());
    }
}
