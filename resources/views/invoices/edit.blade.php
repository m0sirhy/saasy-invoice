@extends('layouts.app')
@section('title', 'Edit Invoice #' . $invoice['id'])
@section('content')
@php
$url = '/api/invoice/update/'. $invoice['id']
@endphp
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('invoices') }}">Invoices</a> / Edit Invoice</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Invoice Details</h5>
            </div>
            <div class="text-right text-white p-2"><a href="{{ route('invoices.destroy', ['invoice' => $invoice['id']])}}"><button type="button" class="bg-transparent hover:bg-red-700 text-red-700 font-semibold hover:text-white py-1 px-3 border border-red-700 hover:border-transparent rounded"><i class="fa fa-trash"></i></button></a></div>
            <div id="app">
                <invoice-form invoice-model='@json($invoice)' items-model='@json($items)' url='{{ route('api.invoice.update', ['invoice' => $invoice['id']]) }}'>
                    Update
                </invoice-form>
            </div>
        </div>
    </div>
</div>
@endsection
