<?php

namespace App\Http\Livewire;

use App\Billing;
use App\Product;
use App\BillingItem;
use Livewire\Component;

class BillingForm extends Component
{
    public $name;
    public $products;
    public $items = [];
    public $billing = [];
    public $removed = [];
    public $monthlyFee = 0;
    public $monthlyMin = 0;
    public $billingCheck = false;

    public function mount($billing = null, $items = [])
    {
        if (!is_null($billing)) {
            $this->billingCheck = true;
            $this->billing = $billing;
            $this->name = $billing['name'];
            $this->monthlyFee = $billing['monthly_fee'];
            $this->monthlyMin = $billing['monthly_min'];
            $this->items = $items;
        }
        $this->products = Product::get();
    }
    public function updatedName()
    {
        $this->billing['name'] = $this->name;
    }

    public function updatedMonthlyFee()
    {
        $this->billing['monthly_fee'] = $this->monthlyFee;
    }

    public function updatedMonthlyMin()
    {
        $this->billing['monthly_min'] = $this->monthlyMin;
    }

    public function updatedItems($name, $value)
    {
        if (strpos($value, 'product_id') !== false) {
            $product = Product::find($name);
            $index = explode('.', $value)[0];
            $this->items[$index]['price_per'] = $product->unit_price;
        }
    }

    public function addRow()
    {
        $item = [
            'id' => 9999999,
            'billing_id' => 0,
            'product_id' => 0,
            'alt_id' => '',
            'price_per' => 0,
            'price_after' => '',
            'after_min' => 0,
        ];
        array_push($this->items, $item);
    }

    public function removeRow($itemId, $index)
    {
        array_push($this->removed, $itemId);
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function render()
    {
        return view('livewire.billing-form', ['items' => $this->items]);
    }

    public function update()
    {
        $this->validate = [
            //work on this
        ];
        if (!empty($this->billing)) {
            $billing = Billing::find($this->billing['id']);
            $billing->update($this->billing);
            foreach ($this->removed as $remove) {
                BillingItem::find($remove)->delete();
            }
            foreach ($this->items as $item) {
                if ($item['id'] == 9999999) {
                    $item['id'] = null;
                }
                $item['billing_id'] = $billing->id;
                BillingItem::updateOrCreate(['id' => $item['id']], $item);
            }
        }
        return $this->redirect(route('billings'));
    }
    
    public function create()
    {
        $this->validate = [
            //work on this
        ];
        if (!empty($this->billing)) {
            $billing = Billing::create($this->billing);
            $billing->save();
        }
        foreach ($this->items as $item) {
            if ($item['id'] == 9999999) {
                unset($item['id']);
            }
            $item['billing_id'] = $billing->id;
            BillingItem::create($item);
        }

        return $this->redirect(route('billings'));
    }
}
