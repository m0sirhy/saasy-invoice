<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Invoice;
use App\InvoiceItem;
use App\InvoiceStatus;
use App\Product;
use App\Events\InvoiceCreated;
use App\Events\InvoiceUpdated;
use App\Events\InvoiceViewed;
use App\Events\InvoiceDeleted;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        event(new InvoiceUpdated($invoice));
        return response()->json([
            $invoice
        ]);
    }

    public function getByClient(Client $client)
    {
        $invoices = Invoice::where('client_id', $client->id)
            ->where('balance', '>=', 0)
            ->orderBy('id')
            ->get();
        return response()->json($client->invoices->where('balance', '>', 0));
    }

    public function destroy(Invoice $invoice)
    {
        InvoiceItem::where('invoice_id', $invoice->id)->delete();
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
