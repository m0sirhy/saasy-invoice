<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ExcelButton extends Component
{
    public $route;
    public $sortField;
    public $sortAsc;
    public $search;

    protected $listeners = [
        'sortField' => 'sortField',
        'search' => 'search'
    ];

    public function mount($route, $sortField, $sortAsc, $search)
    {
        $this->route = $route;
        $this->sortField = $sortField;
        $this->sortAsc = $sortAsc;
        $this->search = $search;
    }

    public function sortField($sortField, $sortAsc)
    {
        $this->sortField = $sortField;
        $this->sortAsc = $sortAsc;
    }

    public function search($search)
    {
        $this->search = $search;
    }

    public function render()
    {
        return view('livewire.excel-button');
    }
}
