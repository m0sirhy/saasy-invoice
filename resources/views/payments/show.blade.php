@extends('layouts.app')

@section('title', 'Payment #' . $payment->id)

@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2">Payments / {{ $payment->client->name }} / #{{ $payment->id }}</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <p>Client: <a href="{{ route('clients.show', ['client' => $payment->client_id]) }}">{{ $payment->client->name }}</p>
            <p>Invoice: <a href="{{ route('invoices.show', ['invoice' => $payment->invoice_id]) }}">{{ $payment->invoice_id }}</p>
            <p>Amount: ${{ money_format('%i', $payment->amount) }}</p>
            <p>Auth Code: {{ $payment->auth_code }}</p>
            <p><a href="{{ route('payments.refund', ['payment' => $payment->id]) }}" class="link">Refund this payment</a></p>
        </div>
    </div>
</div>
@endsection

@push('footerScripts')

@endpush