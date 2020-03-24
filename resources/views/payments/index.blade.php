@extends('layouts.app')

@section('title', 'Payments')

@section('content')

@livewireStyles
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2">Payments</h3>
</div>
<div class="p-5">
	@livewire('payments')
</div>
@endsection

@livewireScripts
@push('footerScripts')

@endpush