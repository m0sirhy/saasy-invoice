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

    public function mount($credit = null)
    {
        $this->credit = [
            'client_id' => 0,
            'user_id' => Auth::id(),
            'credit_date' => now()->format('Y-m-d'),
            'amount' => 0,
            'balance' => 0,
            'public_notes' => '',
            'private_notes' => '',
            'completed' => 0
        ];
        if (!is_null($credit)) {
            $this->credit = $credit->toArray();
            $this->credit['credit_date'] = $credit->credit_date->format('Y-m-d');
        }
        $this->clients = Client::get();
    }

    public function updating($name, $value)
    {
        if ($name != 'completed') {
            $this->credit[$name] = $value;
        }

        if ($name == 'amount' && $this->credit['balance'] == 0) {
            $this->credit['balance'] = $value;
        }
    }

    public function completedChecked()
    {
        $check = 0;
        if ($this->credit['completed'] == 0) {
            $check = 1;
        }
        $this->credit['completed'] = $check;
    }

    public function render()
    {
        return view('livewire.credit-form');
    }

    public function submit()
    {
        if (isset($this->credit['id'])) {
            Credit::find($this->credit['id'])->update($this->credit);
            return $this->redirect(route('credits'));
        }
        Credit::create($this->credit)->save();
        return $this->redirect(route('credits'));
    }
}
