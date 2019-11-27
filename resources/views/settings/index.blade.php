@extends('layouts.app')

@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2">Settings</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Basic Information</h5>
            </div>
            <div class="p-5">
                <div class="w-full max-w-xl items-center">
                    {!! Form::model($setting, ['route' => ['settings.save']]) !!}
                        <div class="mb-4">
                            {!! Form::label('company', 'Company', ['class' => 'form-label'])  !!}
                            {!! Form::text('company', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('website', 'Website', ['class' => 'form-label'])  !!}
                            {!! Form::text('website', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('email', 'Email', ['class' => 'form-label'])  !!}
                            {!! Form::text('email', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('phone', 'Phone', ['class' => 'form-label'])  !!}
                            {!! Form::text('phone', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('address', 'Address', ['class' => 'form-label'])  !!}
                            {!! Form::text('address', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('address2', 'Address 2', ['class' => 'form-label'])  !!}
                            {!! Form::text('address2', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('city', 'City', ['class' => 'form-label'])  !!}
                            {!! Form::text('city', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('state', 'State', ['class' => 'form-label'])  !!}
                            {!! Form::text('state', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('zipcode', 'Zip Code', ['class' => 'form-label'])  !!}
                            {!! Form::text('zipcode', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('country', 'Country', ['class' => 'form-label'])  !!}
                            {!! Form::text('country', null, ['class' => 'form-input leading-tight focus:outline-none focus:shadow-outline']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::submit('Save', ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="w-full md:w-1/2 xl:w-1/6 p-3">
        @include('settings.nav')
    </div>
</div>
@endsection
