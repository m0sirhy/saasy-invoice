<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Invoice;
use App\Events\InvoiceCreated;
use App\InvoiceItem;
use App\InvoiceStatus;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;

class InvoiceController extends Controller
{
    public function create(Request $request)
    {
        $invoice = Invoice::create($request->all());
        foreach ($request->items as $item) {
            $item['invoice_id'] = $invoice->id;
            InvoiceItem::create($item);
        }
        $invoice->amount = $this->getTotal($request->items);
        $invoice->balance = $this->getTotal($request->items);
        $invoice->save();
        event(new InvoiceCreated($invoice));
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
        $invoice->amount = $this->getTotal($request->items);
        $invoice->save();
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

    public function getTotal($items)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }
        return $total;
    }
}
