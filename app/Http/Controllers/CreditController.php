<?php

namespace App\Http\Controllers;

use App\Client;
use App\Credit;
use App\DataTables\CreditsDataTable;
use Auth;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CreditsDataTable $dataTable)
    {
        return $dataTable->render('credits.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('credits.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = Client::findOrFail($request->client_id);
        Credit::create([
            'client_id' => $request->client_id,
            'user_id' => Auth::user()->id,
            'credit_date' => now(),
            'amount' => $request->amount,
            'balance' => $request->amount,
            'notes' => $request->notes,
            'completed' => 0
        ]);
        return redirect()->route('credits');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function show(Credit $credit)
    {
        return view('credits.show')
            ->with('credit', $credit);
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
        return redirect()->route('credits');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Credit $credit)
    {
        $credit->delete();
        return redirect()->route('credits');
    }
}
