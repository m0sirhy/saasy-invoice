<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Billing;
use App\BillingItem;

class BillingController extends Controller
{
    public function create(Request $request)
    {
        $billing = Billing::create($request->all());
        foreach ($request->items as $item) {
            $item['billing_id'] = $billing->id;
            BillingItem::create($item);
        }
        return response()->json($billing);
    }

    public function getAll()
    {
        $billings = Billing::orderBy('name')->get();
        return response()->json($billings);
    }

    public function destroy(Billing $billing)
    {
        $billing->delete();
        return response()->json('Billing deleted');
    }

    public function show(Billing $billing)
    {
        return response()->json($billing);
    }

    public function update(Request $request, Billing $billing)
    {
        $data = $request->all();
        $billing = Billing::updateOrCreate(
            ['id'=> $data['id']],
            [
               'name' => $data['name'],
               'monthly_fee' => $data['monthly_fee'],
               'monthly_min' => $data['monthly_min']
            ]
        );
        BillingItem::where('billing_id', $billing->id)->delete();
        foreach ($data['items'] as $item) {
            $item['billing_id'] = $billing->id;
            BillingItem::create($item);
        }
        return response()->json($billing);
    }
}
