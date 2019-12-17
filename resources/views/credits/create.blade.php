@extends('layouts.app')
@section('title', 'New Credit')
@section('content')

<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('credits') }}">Credits</a> / New Credit</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Credit Details</h5>
            </div>
            <div class="p-5" id="app">
                <credit-form credit-model='' url='{{ route('api.credit.create') }}'>
                </credit-form>
            </div>
        </div>
    </div>
</div>
@endsection
