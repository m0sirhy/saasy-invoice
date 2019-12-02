@extends('layouts.app')

@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2">Clients / {{ $client->name }}</h3>
</div>
<div class="p-5">

</div>
@endsection

@push('footerScripts')

@endpush