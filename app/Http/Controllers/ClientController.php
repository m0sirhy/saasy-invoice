<?php

namespace App\Http\Controllers;

use App\Client;
use App\Credit;
use App\Invoice;
use App\Payment;
use App\ClientToken;
use App\Subscription;
use Illuminate\Http\Request;
use App\WireTables\ClientsWireTable;
use App\DataTables\ClientCreditsDataTable;
use App\DataTables\ClientInvoicesDataTable;
use App\DataTables\ClientPaymentsDataTable;

class ClientController extends Controller
{
    public function index(ClientsWireTable $wiretable)
    {
        return $wiretable->render();
    }

    public function create()
    {
        return view('clients.create');
    }

    public function save(Request $request)
    {
        Client::create($request->all());
        return redirect()->route('clients');
    }

    public function delete(Client $client)
    {
        $client->delete();
        return redirect()
            ->route('clients')
            ->withSuccess("Client {$client->first_name} {$client->last_name} has been deleted");
    }

    /**
     * Display a listing of the resource.
     *
     * @param Client $client
     * @param ClientInvoicesDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client, ClientInvoicesDataTable $dataTable)
    {
        return $dataTable->with('client', $client)
            ->render('clients.show', compact('client', $client));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Client $client
     * @param ClientInvoicesDataTable $dataTab
     * @return \Illuminate\Http\Response
     */
    public function paymentsShow(Client $client, ClientPaymentsDataTable $dataTable)
    {
        return $dataTable->with('client', $client)->render('clients.payments', compact('client', $client));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Client $client
     * @param ClientInvoicesDataTable $dataTab
     * @return \Illuminate\Http\Response
     */
    public function creditsShow(Client $client, ClientInvoicesDataTable $dataTable)
    {
        return $dataTable->with('client', $client)->render('clients.credits', compact('client', $client));
    }

    /**
     * Merge a client
     *
     * @param Client $client
     * @return \Illuminate\Http\View
     */
    public function merge(Client $client)
    {
        return view('clients.merge')
            ->with('client', $client);
    }

    public function merging(Request $request, Client $client)
    {
        $oldClient = Client::find($request->old_client_id);
        $token = ClientToken::where('client_id', $client->id)
            ->first();
        if (is_null($token)) {
            ClientToken::where('client_id', $oldClient->id)
                ->update(['client_id' => $client->id]);
        }
        Credit::where('client_id', $oldClient->id)
            ->update(['client_id' => $client->id]);
        Invoice::where('client_id', $oldClient->id)
            ->update(['client_id' => $client->id]);
        Payment::where('client_id', $oldClient->id)
            ->update(['client_id' => $client->id]);
        $subs = Subscription::where('client_id', $client->id)
            ->first();
        if (is_null($subs)) {
            Subscription::where('client_id', $oldClient->id)
                ->update(['client_id' => $client->id]);
        }
        $client->notes .= ' Merged client #' . $oldClient->id;
        $client->save();
        $oldClient->notes .= ' Merged into client #' . $client->id;
        $oldClient->save();
        $oldClient->delete();
        return redirect()->route('clients.show', ['client' => $client->id])
            ->withSuccess('Client merged into this one!');
    }
}
