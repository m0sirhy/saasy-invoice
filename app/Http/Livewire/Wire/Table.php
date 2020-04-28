<?php

namespace App\Http\Livewire\Wire;

use Livewire\WithPagination;
use Livewire\Component;

class Table extends Component
{

    use WithPagination;

    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true;
    public $search = '';

    public $table;
    public $model;

    public function mount($table = [], $model = "")
    {
        $this->table = $table;
        $this->model = $model;
    }

    public function render()
    {
        $table = collect($this->table);
        $data = $this->model::join('clients', 'credits.client_id', 'clients.id')
            ->select($table->keys()->toArray())
            ->joinLike($table->keys(), $this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.wire.table')
            ->with('data', $data)
            ->with('table', $table)
            ->with('title', 'Credits');
    }

    public function updatedSearch()
    {
        $this->emit('search', trim($this->search));
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
