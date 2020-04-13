<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<style>
		.invoice-box {
			max-width: 800px;
			margin: auto;
			padding: 30px;
			border: 1px solid #eee;
			box-shadow: 0 0 10px rgba(0, 0, 0, .15);
			font-size: 16px;
			line-height: 24px;
			font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			color: #555;
		}
		.invoice-box table {
			width: 100%;
		}
		.invoice-box table td {
			padding: 10px;
			vertical-align: top;
		}
		.invoice-item {
			border-bottom: 1px solid #8c8c8c;
		}

	</style>
</head>
<body>
	<div class="invoice-box">
		<table width="100%">
			<tr>
				<td><h1>Invoice #{{ $data->id }}</h1></td>
				<td style="text-align: right;"><img src="" height="38"><small><br>746 East Winchester, Suite G-20<br>Murray, UT 84107<br>(888) 795-6575<br>support@monitorbase.com</small></td>
			</tr>
		</table>
		<hr>
		<table class="">
			<br><br>
			<tr>
				<td>FOR:<br>{{ ucfirst(strtolower($data->Client->name)) }}<br>{{$data->Client->email}}<br>{{$data->Client->address}}<br>{{$data->Client->city}} {{ $data->Client->state }}, {{ $data->Client->zipcode }}</td>
				<td>
					Invoice #{{ $data->id }}<br>
					Date Invoiced: {{ date("m/d/Y", strtotime($data->invoice_date)) }}<br>
					@if (!is_null($data->start_date))
					Billing Period: {{ date("m/d/Y", strtotime($data->start_date)) }} - {{ date("m/d/Y", strtotime($data->end_date)) }}<br>
					@endif
					<b>Due: {{ date("m/d/Y", strtotime($data->due_date)) }}</b>
				</td>
			</tr>
		</table>
		<br>
		<table style="border-bottom: 2px solid #2D3748;">
			<thead>
				<tr style="margin:auto; color:white; background-color: #2D3748; padding: 2px;">
					<th>
						Description
					</th>
					<th>
						Quantity
					</th>
					<th>
						Unit Price
					</th>
					<th>
						Total
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data->Items as $item)
				<tr>
					<td class="invoice-item">
						{{ $item->name }}<br>
						@if($item->description != '')
						<small><small>{{ $item->description }}</small></small>
						@endif
					</td>
					<td class="invoice-item">
						{{ $item->quantity }}
					</td>
					<td class="invoice-item">
						@include('includes._dollar', ['number' => $item->unit_price])
					</td>
					<td class="invoice-item">
						@include('includes._dollar', ['number' => $item->unit_price * $item->quantity])
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<h3 style="text-align: right;">Total: @include('includes._dollar', ['number' => $item->amount])</h3>
		<h3 style="text-align: right;">Balance Due: @include('includes._dollar', ['number' => $item->balance])</h3>
		@if ($data->public_notes != "")
			<strong>Notes:</strong><br/>
			{{ $data->public_notes }}
		@endif
	</div>
</body>
</html>