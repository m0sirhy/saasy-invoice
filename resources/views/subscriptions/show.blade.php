@extends('layouts.app')

@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2">Subscriptions</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-full p-5">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="p-5">
            	{!! Form::model($subscription, ['route' => ['subscriptions.save', 'subscription' => $subscription->id]]) !!}
            		{!!Form::hidden('id', $subscription->id)!!}
            		<div class="mb-4">
            			{!! Form::label('billing_type_id', 'Billing Type Id', ['class' => 'form-label']) !!}
            			{!! Form::text('billing_type_id', null, ['class' => 'form-input']) !!}
            		</div>
            		<div class="mb-4">
            			{!! Form::label('client_id', 'Client Id', ['class' => 'form-label']) !!}
            			{!! Form::text('client_id', null, ['class' => 'form-input']) !!}
            		</div>
            		<div class="mb-4">
        				{!! Form::label('last_invoice_id', 'Last Invoice Id', ['class' => 'form-label']) !!}
            			{!! Form::text('last_invoice_id', null, ['class' => 'form-input']) !!}
        			</div>
            		<div class="mb-4">
            			{!! Form::label('last_invoice_date', 'Last Invoice Date', ['class' => 'form-label']) !!}
            			{!! Form::text('last_invoice_date', null, ['class' => 'form-input']) !!}
            		</div>
					<div class="mb-4">
            			{!! Form::label('next_invoice_date', 'Next Invoice Date', ['class' => 'form-label']) !!}
            			{!! Form::text('next_invoice_date', null, ['class' => 'form-input']) !!}
            		</div>
            		<div class="mb-4">
            			{!! Form::label('total_invoices', 'total_invoices', ['class' => 'form-label']) !!}
            			{!! Form::text('total_invoices', null, ['class' => 'form-input']) !!}
            		</div>
            		<div class="mb-4">
            			{!! Form::label('total_billed', 'Total Amount Billed', ['class' => 'form-label']) !!}
            			{!! Form::text('total_billed', null, ['class' => 'form-input']) !!}
            		</div>
            		<div class="mb-4">
            			{!! Form::label('total_payed', 'total_payed', ['class' => 'form-label']) !!}
            			{!! Form::text('total_payed', null, ['class' => 'form-input']) !!}
            		</div>
            		<div class="mb-4">
            			{!! Form::label('created_at', 'Subscription Created Date', ['class' => 'form-label']) !!}
            			{!! Form::text('created_at', null, ['class' => 'form-input']) !!}
            		</div>
            		<div class="mb-4">
            		{!! Form::submit('Save', ['class' => 'bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) !!}
	            	</div>
        		{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection
