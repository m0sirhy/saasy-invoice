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
     * @param String $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription) {
    	return view('subscriptions.show', compact('subscription'));
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
        $parameters = array_diff_key($request->all(), ['_token' => '']); 
        Subscription::create($parameters);
        return redirect()->route('subscriptions');
    }
}
