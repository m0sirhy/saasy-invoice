@extends('layouts.app')
@section('title', 'Payment Settings')
@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('settings') }}">Settings</a> / Payment</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Gateways</h5> 
            </div>
            <div class="p-5">
              <table class="table-fixed w-full  sm:bg-white rounded-lg sm:shadow-lg my-5">
                <thead>
                  <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Active</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($paymentGateways as $paymentGateway)
                  <tr>
                    <td class="border px-4 py-2">{{ $paymentGateway->name }}</td>
                    <td class="border px-4 py-2">{{ $paymentGateway->active ? "Yes" : "No" }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>

        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Gateway Settings</h5> 
            </div>
            <div class="p-5">
                    {!! Form::model($paymentGatewaySetting, ['route' => ['settings.payment.save']]) !!}
                        <div class="mb-4">
                            {!! Form::label('username', 'Username / Auth Name', ['class' => 'form-label'])  !!}
                            {!! Form::text('username', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('key', 'Key', ['class' => 'form-label'])  !!}
                            {!! Form::password('key', ['class' => 'form-input']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('public_key', 'Public Key', ['class' => 'form-label'])  !!}
                            {!! Form::text('public_key', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('test_mode', 'Test Mode', ['class' => 'form-label'])  !!}
                            {!! Form::checkbox('test_mode', '1') !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::submit('Save', ['class' => 'bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) !!}
                        </div>
                    {!! Form::close() !!}
            </div>
        </div>

    </div>
    <div class="w-full md:w-1/2 xl:w-1/6 p-3">
        @include('settings.nav')
    </div>
</div>
@endsection
