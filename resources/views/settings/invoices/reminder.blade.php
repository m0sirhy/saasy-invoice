@extends('layouts.app')
@section('title', 'Reminder Settings')
@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('settings') }}">Settings</a> / Reminder</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Reminder Settings</h5>
            </div>
            <div class="px-5 p-4">
            	<div class="flex items-center">
            		<div class="p-4 w-3/4">
            			{!! Form::model($setting, ['route' => 'settings.reminders.save']) !!}
		            	<label class="form-label">
		            		1st Reminder
		            	</label>
            			{!! Form::label('remind_days1', '', ['class' => 'form-label hidden']) !!}
            			{!! Form::text('remind_days1', null, ['class' => 'shadow appearance-none border rounded w-1/6 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']) !!}
		            	<span class="w-1/4 py-2 px-2 text-gray-700">Days After The</span>
		            	{!! Form::label('remind_after1', '', ['class' => 'form-label hidden']) !!}
		            	{!! Form::select('remind_after1', ['1' => 'Due Date', '2' => 'Invoice Date'], null,  ['class' => "shadow border rounded w-1/6 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"]) !!}
		            	<span class="py-2 px-3 text-gray-700 leading-tight">
			            	{!! Form::checkbox('remind_enable1', 1, $setting->remind_enable1, ['id' => 'remind_enable3']) !!}
			            	<label for="remind_enable1">enable</label>
			            </span>
		            	<label class="form-label">
		            		2nd Reminder
		            	</label>
            			{!! Form::label('remind_days2', '', ['class' => 'form-label hidden']) !!}
            			{!! Form::text('remind_days2', null, ['class' => 'shadow appearance-none border rounded w-1/6 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']) !!}
		            	<span class="w-1/4 py-2 px-2 text-gray-700">Days After The</span>
		            	{!! Form::label('remind_after2', '', ['class' => 'form-label hidden']) !!}
		            	{!! Form::select('remind_after2', ['1' => 'Due Date', '2' => 'Invoice Date'], null,  ['class' => "shadow border rounded w-1/6 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"]) !!}
		            	<span class="py-2 px-3 text-gray-700 leading-tight">
			            	{!! Form::checkbox('remind_enable2', 1, $setting->remind_enable2, ['id' => 'remind_enable3']) !!}
			            	<label for="remind_enable2">enable</label>
			            </span>
		            	<label class="form-label">
		            		3rd Reminder
		            	</label>
            			{!! Form::label('remind_days3', '', ['class' => 'form-label hidden']) !!}
            			{!! Form::text('remind_days3', null, ['class' => 'shadow appearance-none border rounded w-1/6 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']) !!}
		            	<span class="w-1/4 py-2 px-2 text-gray-700">Days After The</span>
		            	{!! Form::label('remind_after3', '', ['class' => 'form-label hidden']) !!}
		            	{!! Form::select('remind_after3', ['1' => 'Due Date', '2' => 'Invoice Date'], null,  ['class' => "shadow border rounded w-1/6 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"]) !!}
		            	<span class="py-2 px-3 text-gray-700 leading-tight">
			            	{!! Form::checkbox('remind_enable3', 1, $setting->remind_enable3, ['id' => 'remind_enable3']) !!}
			            	<label for="remind_enable3">enable</label>
			            </span>
		            </div>
		        </div>
            </div>
            <div class="mb-4">
  				{!! Form::submit('Submit', ['class' => 'bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 m-4 rounded']) !!}
				</div>
				{!! Form::close() !!}
            </div>
        </div>
        <div class="w-full md:w-1/2 xl:w-1/6 p-3">
	    @include('settings.nav')
	    </div>
    </div>
</div>
@endsection