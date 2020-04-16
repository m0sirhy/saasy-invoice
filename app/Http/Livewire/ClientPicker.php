<?php

namespace App\Http\Livewire;

use App\Client;
use Livewire\Component;

class ClientPicker extends Component
{
    public $clientPlaceholder;
    public $clients;
    public $original = 0;
    public $search = '';
    public $clientState = false;
    public $sortField = 'id';

    protected $listeners = ['clientSearch', 'clientStateChange'];

    public function mount($clientId = 0)
    {
        if ($clientId != 0) {
            $client = Client::where('id', $clientId)->first();
            $this->clientPlaceholder = $client->id . ' - ' . $client->name . ' - ' . $client->email;
            $this->original = $this->clientPlaceholder;
        }
        $this->clients = Client::orderBy($this->sortField, 'asc')
            ->select(['id', 'name', 'email'])
            ->limit(100)
            ->get();
    }

    public function clientSearch($search)
    {
        $this->search = $search;
        
        $cols = ['id', 'name', 'email'];
        $clients = Client::whereLike($cols, $this->search)
            ->orderBy($this->sortField, 'asc')
            ->select(['id', 'name', 'email'])
            ->limit(100)
            ->get();
        $this->clients = $clients;
    }

    public function clientClicked($clientId, $clientName, $clientEmail)
    {
        $this->clientPlaceholder = $clientId . ' - ' . $clientName . ' - ' . $clientEmail;
        $this->search = '';
        $this->emit('clientUpdated', $clientId);
    }

    public function clientStateChange()
    {
        $this->search='';
        $this->clientSearch($this->search);
    }

    public function render()
    {
        return view('livewire.client-picker');
    }
}
