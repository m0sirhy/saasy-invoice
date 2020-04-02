<?php

namespace App\Http\Livewire;

use App\Client;
use App\Invoice;
use App\Product;
use App\InvoiceItem;
use App\InvoiceStatus;
use Livewire\Component;
use App\Events\InvoiceCreated;
use App\Events\InvoiceUpdated;

class InvoiceForm extends Component
{
    public $status;
    public $invoice;
    public $clients;
    public $dueDate;
    public $endDate;
    public $products;
    public $clientId;
    public $startDate;
    public $invoiceDate;
    public $invoiceStatuses;
    public $mail = 0;
    public $total = 0;
    public $items = [];
    public $balance = 0;
    public $removed = [];
    public $publicNotes = '';
    public $privateNotes = '';
    public $invoiceCheck = false;
    public $invoiceId;

    public function mount($invoice = null, $items = [])
    {
        $this->status = DRAFT;
        if (!is_null($invoice)) {
            $this->invoiceCheck = true;
            $this->invoice = $invoice->toArray();
            $this->invoiceDate = $invoice['invoice_date']->format('Y-m-d');
            $this->dueDate = date('Y-m-d', strtotime($invoice['due_date'] . '00:00:00'));
            $this->startDate = date('Y-m-d', strtotime($invoice['start_date'] . '00:00:00'));
            $this->endDate = date('Y-m-d', strtotime($invoice['end_date'] . '00:00:00'));
            $this->clientId = $invoice['client_id'];
            $this->items = $items->toArray();
            $this->total = $invoice['amount'];
            $this->balance = $invoice['balance'];
            $this->mail = $invoice['mail'];
            $this->publicNotes = $invoice['public_notes'];
            $this->privateNotes = $invoice['private_notes'];
            $this->invoiceId = $invoice['id'];
            $this->status = $invoice['invoice_status_id'];
        }
        $this->products = Product::get();
        $this->invoiceStatuses = InvoiceStatus::get();
        $this->clients = Client::get();
    }

    public function updatedClientId()
    {
        $this->invoice['client_id'] = $this->clientId;
    }

    public function updatedInvoiceDate()
    {
        $this->invoice['invoice_date'] = $this->invoiceDate;
    }

    public function updatedDueDate()
    {
        $this->invoice['due_date'] = $this->dueDate;
    }

    public function updatedStartDate()
    {
        $this->invoice['start_date'] = $this->startDate;
    }

    public function updatedEndDate()
    {
        $this->invoice['endDate'] = $this->endDate;
    }

    public function updatedStatus()
    {
        $this->invoice['invoice_status_id'] = $this->status;
    }

    public function updatedItems($name, $value)
    {
        if (strpos($value, 'product_id') !== false) {
            $product = Product::find($name);
            $index = explode('.', $value)[0];
            $this->items[$index]['description'] = $product->notes;
            $this->items[$index]['unit_price'] = $product->unit_price;
        }
        $this->totalUpdate();
    }

    public function removeRow($itemId, $index)
    {
        array_push($this->removed, $itemId);
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->totalUpdate();
    }

    public function totalUpdate()
    {
        $this->total = $this->balance = 0;
        foreach ($this->items as $item) {
            $this->total += $item['unit_price'] * $item['quantity'];
            $this->balance += $item['unit_price'] * $item['quantity'];
        }
        $this->invoice['amount'] = $this->invoice['balance'] = $this->total;
    }

    public function addRow()
    {
        $item = [
            'id' => 9999999,
            'product_id' => 0,
            'invoice_id' => $this->invoice['id'] ?? 0,
            'quantity' => 0,
            'unit_price' => 1,
            'description' => '',
            'name' => ''
        ];
        array_push($this->items, $item);
    }

    public function mailChecked()
    {
        $check = 0;
        if ($this->mail == 0) {
            $check = 1;
        }
        $this->mail = $check;
        $this->invoice['mail'] = $this->mail;
    }

    public function updatedPublicNotes()
    {
        $this->invoice['public_notes'] = $this->publicNotes;
    }

    public function updatedPrivateNotes()
    {
        $this->invoice['private_notes'] = $this->privateNotes;
    }
    
    public function render()
    {
        return view('livewire.invoice-form', ['items' => $this->items]);
    }

    public function update()
    {
        $this->validate = [
            //work on this
        ];
        if (!empty($this->invoice)) {
            $invoice = Invoice::find($this->invoice['id']);
            $invoice->update($this->invoice);
            foreach ($this->removed as $remove) {
                InvoiceItem::find($remove)->delete();
            }
            foreach ($this->items as $item) {
                if ($item['id'] == 9999999) {
                    $item['id'] = null;
                }
                $item['invoice_id'] = $invoice->id;
                InvoiceItem::updateOrCreate(['id' => $item['id']], $item);
            }
        }
        event(new InvoiceUpdated($invoice, $this->mail));
        return redirect()->route('invoices');
    }
    public function create()
    {
        $this->validate = [
            //work on this
        ];
        if (!empty($this->invoice)) {
            $invoice = Invoice::create($this->invoice);
            $invoice->save();
        }
        foreach ($this->items as $item) {
            if ($item['id'] == 9999999) {
                unset($item['id']);
            }
            $item['invoice_id'] = $invoice->id;
            InvoiceItem::create($item);
        }
        event(new InvoiceCreated($invoice, $this->mail));
        return redirect()->route('invoices');
    }
}
