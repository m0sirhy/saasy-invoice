<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Payment;
use DB;

class Payments extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = false;
    public $search = '';

    public function render()
    {
        $cols = ['id', 'invoice_id', 'auth_code', 'amount'];
        $payments = Payment::with('client')
            ->whereLike($cols, $this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.payments', [
            'payments' => $payments,
            'types' => Payment::TYPES,
        ]);
    }

    public function sortBy($field)
    {
        $this->sortAsc = true;
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        }
        $this->sortField = $field;
    }
}
