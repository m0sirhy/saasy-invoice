<?php

namespace App\Http\Livewire;

use Auth;
use App\Client;
use App\Credit;
use Livewire\Component;

class CreditForm extends Component
{
    public $credit;
    public $clients;
    public $amount = 0;
    public $notes = '';
    public $balance = 0;
    public $client_id = 0;
    public $completed = 0;
    public $creditCheck = false;
    public $credit_date = '0000-00-00';

    public function mount($credit = null)
    {
        $this->credit = [
            'client_id' => 0,
            'user_id' => Auth::id(),
            'credit_date' => now()->format('Y-m-d'),
            'amount' => $this->amount,
            'balance' => $this->balance,
            'notes' => $this->notes
        ];
        if (!is_null($credit)) {
            $this->creditCheck = true;
            $this->client_id = $credit->client_id;
            $this->credit_date = $credit->credit_date->format('Y-m-d');
            $this->completed = $credit->completed;
            $this->amount = $credit->amount;
            $this->amount = $credit->amount;
            $this->balance = $credit->balance;
            $this->notes = $credit->notes;
            $this->credit = $credit->toArray();
        }
        $this->clients = Client::get();
    }

    public function updating($name, $value)
    {
        if ($name != 'completed') {
            $this->credit[$name] = $value;
        }
    }

    public function completedChecked()
    {
        $check = 0;
        if ($this->completed == 0) {
            $check = 1;
        }
        $this->completed = $check;
        $this->credit['completed'] = $this->completed;
    }

    public function render()
    {
        return view('livewire.credit-form');
    }

    public function submit()
    {
        $this->validate = [
            //work on this
        ];
        if ($this->creditCheck && !is_null($this->credit)) {
            Credit::find($this->credit['id'])->update($this->credit);
            return $this->redirect(route('credits'));
        }
        Credit::create($this->credit)->save();
        return $this->redirect(route('credits'));
    }
}
