@extends('layouts.app')
@section('title', 'Activate Account')
@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('settings') }}">Settings</a> / <a href="{{ route('users') }}">Users</a></h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">User Details</h5>
            </div>
            <div class="p-5">
                <div class="w-full max-w-xl items-center">
                    {!! Form::model($user, ['route' => ['user.update', 'user' => $user->id]]) !!}
                    {!! Form::hidden('activate', 1) !!}
                    <div class="mb-4">
                        {!! Form::label('name', 'Name', ['class' => 'form-label'])  !!}
                        {!! Form::text('name', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                    </div>
                    <div class="mb-4">
                        {!! Form::label('email', 'Email', ['class' => 'form-label'])  !!}
                        {!! Form::text('email', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                    </div>
                    <div class="mb-4">
                        {!! Form::label('password', 'Password', ['class' => 'form-label'])  !!}
                        {!! Form::password('password', ['class' => 'form-input']) !!}
                    </div>
                    <div class="mb-4">
                        {!! Form::submit('Save', ['class' => 'bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
