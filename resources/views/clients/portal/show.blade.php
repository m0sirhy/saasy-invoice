@extends('layouts.client')

@section('title','Invoice #' . $invoice->id)

@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
	<h3 class="font-bold pl-2">Invoice #{{ $invoice->id }}</h3>
</div>
<div class="bg-blue-100">
	<div class="container mx-auto rounded overflow-hidden shadow-lg bg-white">
		<div class="px-6 py-4">
			<table class="table-auto w-full">
				<tbody>
					<tr>
						<td class="px-4 py-2 w-3/4">
							<p class="text-2xl">Invoice #{{ $invoice->id }}</p>
						</td>
						<td class="px-4 py-2 w-1/4">
							<small>FROM:</small>
							<h3 class="text-lg">{{$setting->company}}</h3>
							<p>{{$setting->address}}</p>
							@if ($setting->address2 != '')
							<p>{{$setting->address2}}</p>
							@endif
							<p>{{$setting->city}} {{$setting->state}}, {{$setting->zipcode}}</p>
						</td>
					</tr>
				</tbody>
			</table>
			<hr class="p-6">
			<table class="table-auto w-full">
				<tbody>
					<tr>
						<td class="px-4 py-2">
							<small>FOR:</small>
							<h3 class="text-lg">{{ Auth::user()->name }}</h3>
							<p>{{ Auth::user()->address }}</p>
							<p>{{ Auth::user()->city }} {{ Auth::user()->state }}, {{ Auth::user()->zipcode }}</p>
						</td>
						<td class="px-4 py-2">
							<p class="text-lg">Invoice #{{ $invoice->id }}</p>
							<p>Date Invoiced: {{ date('m/d/Y', strtotime($invoice->invoice_date)) }}</p>
							<p>Billing Period: {{ date('m/d/Y', strtotime($invoice->start_date)) }} - {{ date('m/d/Y', strtotime($invoice->end_date)) }}</p>
							<p>Due: {{ date('m/d/Y', strtotime($invoice->due_date)) }}</p>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="table-auto w-full mt-6">
				<thead class="bg-gray-800 text-white">
					<tr>
						<th class="px-4 py-2 text-left">Description</th>
						<th class="px-4 py-2 text-right">Quantity</th>
						<th class="px-4 py-2 text-right">Unit Price</th>
						<th class="px-4 py-2 text-right">Total</th>
					</tr>
				</thead>
				<tbody>
					@foreach($invoice->Items as $item)
					<tr class="border">
						<td class="px-4 py-2">
							{{ $item->name }}<br>
							@if($item->description != '')
							<p class="text-xs">{{ $item->description }}</p>
							@endif
						</td>
						<td class="px-4 py-2 text-right">
							{{ $item->quantity }}
						</td>
						<td class="px-4 py-2 text-right">
							@include('includes._dollar', ['text' => $item->unit_price])
						</td>
						<td class="px-4 py-2 text-right bg-gray-200">
							@include('includes._dollar', ['text' => $item->quantity * $item->unit_price])
						</td>
					</tr>
					@endforeach
					<tr class="border-t-2 border-gray-800">
						<td colspan="2" class="px-4 py-2 text-right"></td>
						<td class="px-4 py-2 text-right font-medium">Invoice Total</td>
						<td class="px-4 py-2 text-right border bg-gray-200">
							@include('includes._dollar', ['text' => $invoice->amount])
						</td>
					</tr>
					<tr>
						<td colspan="2" class="px-4 py-2 text-left">
							<a href="{{ route('client.invoice.download', ['invoice' => $invoice->public_id]) }}"><button class="btn-std btn-std-blue" type="button"><i class="fa fa-download"></i> Download</button></a>
							@if ($invoice->balance > 0)
							<a href="{{ route('client.invoice.pay', ['invoice' => $invoice->public_id]) }}"><button class="btn-std btn-std-green" type="button"><i class="fa fa-money-bill"></i> Make Payment</button></a>
							@endif
						</td>
						<td class="px-4 py-2 text-right font-medium">Balance Due</td>
						<td class="px-4 py-2 text-right border bg-gray-200">
							@include('includes._dollar', ['text' => $invoice->balance])
						</td>
					</tr>
					@if ($invoice->public_notes != "")
					<tr>
						<td colspan="4" class="px-4 py-2 text-left">
							<strong>Notes:</strong><br/>
							{{ $invoice->public_notes }}
						</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection
