@extends('layouts.app')
@section('title', 'Edit Credit')
@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('credits') }}">Credits</a> / Edit</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Edit Credit</h5>
            </div>
            <div class="p-5">
                <div class="w-full max-w-xl items-center">
                    {!! Form::model($credit, ['route' => ['credits.update', $credit->id]]) !!}
                        <div class="mb-4">
                            {!! Form::label('client_id', 'Client ID', ['class' => 'form-label'])  !!}
                            {!! Form::text('client_id', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('credit_date', 'Credit Date', ['class' => 'form-label'])  !!}
                            {!! Form::text('credit_date', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('amount', 'Amount', ['class' => 'form-label'])  !!}
                            {!! Form::text('amount', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('balance', 'Remaing Balance', ['class' => 'form-label'])  !!}
                            {!! Form::text('balance', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('notes', 'Notes', ['class' => 'form-label'])  !!}
                            {!! Form::text('notes', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('completed', 'Completed?', ['class' => 'form-label'])  !!}
                            {!! Form::checkbox('completed', 1) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::submit('Save', ['class' => 'bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
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
                    <li><a href="{{ route('credits.destroy', ['credit' => $credit->id]) }}" class="link">Delete</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
