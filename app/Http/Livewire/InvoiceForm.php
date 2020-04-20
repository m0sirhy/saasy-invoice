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
    public $status = 1;
    public $invoice = [];
    public $dueDate;
    public $endDate;
    public $clientId;
    public $startDate;
    public $invoiceDate;
    public $invoiceStatuses;
    public $mail = 0;
    public $total = 0;
    public $balance = 0;
    public $removed = [];
    public $publicNotes = '';
    public $privateNotes = '';
    public $invoiceCheck = false;
    public $invoiceId;

    protected $listeners = ['clientUpdated', 'update', 'create'];

    public function mount($invoice = null)
    {
        $this->status = DRAFT;
        if (!is_null($invoice)) {
            $this->invoiceCheck = true;
            $this->invoice = $invoice->toArray();
            $this->invoiceDate = now()->format('Y-m-d');
            if (!is_null($invoice['invoice_date'])) {
                $this->invoiceDate = $invoice['invoice_date']->format('Y-m-d');
            }
            $this->dueDate = date('Y-m-d', strtotime($invoice['due_date'] . '00:00:00'));
            $this->startDate = date('Y-m-d', strtotime($invoice['start_date'] . '00:00:00'));
            $this->endDate = date('Y-m-d', strtotime($invoice['end_date'] . '00:00:00'));
            $this->clientId = $invoice['client_id'];
            $this->total = $invoice['amount'];
            $this->balance = $invoice['balance'];
            $this->mail = $invoice['mail'];
            $this->publicNotes = $invoice['public_notes'];
            $this->privateNotes = $invoice['private_notes'];
            $this->invoiceId = $invoice['id'];
            $this->status = $invoice['invoice_status_id'];
        }
        $this->invoiceStatuses = InvoiceStatus::get();
    }

    public function clientUpdated($clientId)
    {
        if (is_numeric($clientId)) {
            $this->invoice['client_id'] = $clientId;
        }
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
        $this->invoice['end_date'] = $this->endDate;
    }

    public function updatedStatus()
    {
        $this->invoice['invoice_status_id'] = $this->status;
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
        return view('livewire.invoice-form');
    }

    public function update($items, $total, $balance)
    {
        $this->validate = [
            
        ];
        if (!empty($this->invoice)) {
            $total = str_replace(['$', ','], "", $total);
            $balance = str_replace(['$', ','], "", $balance);
            $this->invoice['amount'] = $total;
            $this->invoice['balance'] = $balance;
            $invoice = Invoice::find($this->invoice['id']);
            $invoice->update($this->invoice);
            InvoiceItem::where('invoice_id', $invoice->id)->delete();
            foreach ($items as $item) {
                $item['invoice_id'] = $invoice->id;
                InvoiceItem::updateOrCreate(['id' => $item['id']], $item);
            }
        }
        event(new InvoiceUpdated($invoice, $this->mail));
        return redirect()->route('invoices');
    }
    public function create($items, $total, $balance)
    {
        $this->validate = [
            //work on this
        ];
        if (!empty($this->invoice)) {
            if (!array_key_exists('invoice_status_id', $this->invoice)) {
                $this->invoice['invoice_status_id'] = 1;
            }
            $total = str_replace(['$', ','], "", $total);
            $balance = str_replace(['$', ','], "", $balance);
            $this->invoice['amount'] = $total;
            $this->invoice['balance'] = $balance;
            $invoice = Invoice::create($this->invoice);
            $invoice->save();
        }
        foreach ($items as $item) {
            unset($item['id']);
            $item['invoice_id'] = $invoice->id;
            InvoiceItem::create($item);
        }
        event(new InvoiceCreated($invoice, $this->mail));
        return redirect()->route('invoices');
    }
}
