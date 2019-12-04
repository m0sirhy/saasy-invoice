<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Redirect;
use App\DataTables\SubscriptionsDataTable;

class SubscriptionController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @param \App\Datatables\SubsctiptionsDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(SubscriptionsDataTable $dataTable) {
    	return $dataTable->render('subscriptions.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param String $id
     * @return \Illuminate\Http\Response
     */
    public function show(String $id) {
    	$subscription = Subscription::where('id', $id)->first();

    	return view('subscriptions.view', compact('subscription'));
    }

    /**
     * Display the form to create a new Subscription
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
    	return view('subscriptions.new');
    }

    /**
     *
     * @param Illuminate\Http\Request $request
     * @return App\Http\Controllers\Redirect
     *
     */
    public function save(Request $request) {
    	$parameters = array_diff_key($request->all(), ['_token' => '']);
    	Subscription::updateOrCreate([
    		'id' => $parameters['id']
    	],
    	$parameters);
    	return redirect()->route('subscriptions');
    }

    /**
     *
     * @param Illuminate\Http\Request $request
     * @return App\Http\Controllers\Redirect
     *
     */

    public function store(Request $request) {
    	$subscription = new Subscription;
    	$subscription->billing_type_id = $request->billing_type_id;
    	$subscription->client_id = $request->client_id;
    	$subscription->next_invoice_date = $request->next_invoice_date;
    	$subscription->total_billed = $request->total_billed;
    	$subscription->total_payed = $request->total_payed;
    	$subscription->save();
    	return redirect()->route('subscriptions');
    }
}
