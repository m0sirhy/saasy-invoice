<?php

namespace App\Http\Livewire;

use App\Payment;
use Livewire\Component;
use Livewire\WithPagination;

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
        $payments = Payment::with('Client')
            ->whereLike($cols, $this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.payments', [
            'payments' => $payments,
            'types' => Payment::TYPES,
        ]);
    }

    public function updatedSearch()
    {
        $this->emit('search', $this->search);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortField = $field;
        $this->emit('sortField', $this->sortField, $this->sortAsc);
    }
}
