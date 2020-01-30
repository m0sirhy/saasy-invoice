@extends('layouts.app')
@section('title', 'Commissions Owed')
@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2">Commissions Owed</h3>
</div>
<div class="flex flex-wrap">
	<div class="w-full md:w-1/2 xl:w-5/6 p-5">
	  {{$dataTable->table()}}
	</div>
	<div class="w-full md:w-1/2 xl:w-1/6 p-3">
		@include('commissions.nav')
	</div>
</div>
@endsection

@push('footerScripts')
    {{$dataTable->scripts()}}
@endpush