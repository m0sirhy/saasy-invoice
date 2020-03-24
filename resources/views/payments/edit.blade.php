@extends('layouts.app')
@section('title', 'Edit Payment')
@section('content')
@livewireStyles
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('credits') }}">Payments</a> / Edit Payment</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Payment Details</h5>
            </div>
            <div class="p-5">
                @livewire('payment-form', ['payment' => $payment, 'types'=> $types, 'invoices' => $invoices])
            </div>
        </div>
    </div>
    <div class="w-full md:w-1/2 xl:w-1/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Navigation</h5>
            </div>
            <div class="p-5">
                <ul>
                    <li><a href="{{ route('payments.refund', ['payment' => $payment['id']]) }}" class="link">Refund</a></li>
                    <li><a href="{{ route('payments.destroy', ['payment' => $payment['id']]) }}" class="link">Delete</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
@livewireScripts
@push('footerScripts')

@endpush
