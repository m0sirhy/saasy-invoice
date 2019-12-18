<?php

namespace App\Http\Controllers\Api;

use App\Credit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class CreditController extends Controller
{
    public function create(Request $request)
    {
        $completed = 0;
        $balance = $request->amount;
        if (isset($request->completed)) {
            $completed = 1;
            $balance = 0;
        }
        $credit = Credit::create([
            'client_id' => $request->client_id,
            'user_id' => Auth::user()->id,
            'credit_date' => $request->credit_date,
            'amount' => $request->amount,
            'balance' => $balance,
            'notes' => $request->notes,
            'completed' => $completed
        ]);
        return response()->json($credit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Credit $credit)
    {
        $credit->update($request->all());
        if ($request->completed == 1) {
            $credit->balance = 0;
            $credit->save();
        }
        return response()->json(['status' => 200]);
    }


    public function getAll(Request $request)
    {
        $credits = Credit::orderBy('name')->get();
        return response()->json($credits);
    }

    public function destroy(Credit $credit)
    {
        $credit->delete();
        return response()->json('Credit deleted');
    }

    public function show(Credit $credit)
    {
        return response()->json($credit);
    }

    public function showCrm($crmId)
    {
        $credit = Credit::where('crm_id', $crmId)->first();
        return response()->json($credit);
    }
}
