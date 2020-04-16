@extends('layouts.app')
@section('title', 'Edit Invoice #' . $invoice['id'])
@section('content')

<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('invoices') }}">Invoices</a> / Edit Invoice</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Invoice Details</h5>
            </div>
            <div class="text-right text-white p-2"><a href="{{ route('invoices.destroy', ['invoice' => $invoice['id']])}}"><button type="button" class="bg-transparent hover:bg-red-700 text-red-700 font-semibold hover:text-white py-1 px-3 border border-red-700 hover:border-transparent rounded"><i class="fa fa-trash"></i></button></a></div>
            <div class="p-5">
                @livewire('invoice-form', ['invoice' => $invoice])
            </div>
        </div>
    </div>
</div>
@endsection
@livewireScripts
@push('footerScripts')

@endpush
