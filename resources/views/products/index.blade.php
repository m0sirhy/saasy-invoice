@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2">Products</h3>
</div>
<div class="p-5">
  {{ $dataTable->table() }}
</div>
@endsection

@push('footerScripts')
    {{ $dataTable->scripts() }}
@endpush