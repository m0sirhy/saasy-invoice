@extends('layouts.app')
@section('title', $client->name)
@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2">Clients / {{ $client->name }}</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Client Details</h5>
            </div>
<div class="flex p-5">
  <div class="w-1/3">
        <p>{{ $client->name }}</p>
        <p><a class="link" href="mailto:{{ $client->email }}">{{ $client->email }}</a></p>
        <p><a class="link" href="{{ route('client.login', ['uuid' => $client->uuid]) }}">Login</a>
  </div>
  <div class="w-1/3">
      <p>{{ $client->address }} {{ $client->address2 }}</p>
      <p>{{ $client->city }}, {{ $client->state }} {{ $client->zipcode }}</p>
  </div>
  <div class="w-1/3">
      <p><strong>Current Balance</strong> ${{ $client->balance }}</p>
      <p><strong>Total Paid</strong> ${{ $client->total_paid }}</p>
  </div>
</div>
        </div>
    </div>
</div>
            
@endsection

@push('footerScripts')

@endpush