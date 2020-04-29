<?php

namespace App\Http\Livewire\Wire;

use Livewire\WithPagination;
use Livewire\Component;

class Table extends Component
{

    use WithPagination;

    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = false;
    public $search = '';

    private $table;
    public $model;
    public $joins;

    public function mount($table = [], $model = "", $joins = [])
    {
        $this->table = $table;
        $this->model = $model;
        $this->joins = $joins;
    }

    public function render()
    {
        $table = collect($this->table);
        

        $query = $this->model::select($table->keys()->toArray());
        $data = $this->addjoins($query)->joinLike($table->keys(), $this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.wire.table')
            ->with('data', $data)
            ->with('table', $table)
            ->with('title', 'Credits');
    }

    public function addJoins($query)
    {
        foreach ($this->joins as $join) {
            $query->join($join[0], $join[1], $join[2]);
        }
        return $query;
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
