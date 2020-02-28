@extends('layouts.client')

@section('title', 'Dashboard')

@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
	<h3 class="font-bold pl-2">Dashboard</h3>
</div>
<div class="flex flex-wrap">
	<div class="w-full md:w-1/2 xl:w-1/3 p-3">
		<!--Metric Card-->
		<div class="bg-green-100 border-b-4 border-green-600 rounded-lg shadow-lg p-5">
			<div class="flex flex-row items-center">
				<div class="flex-shrink pr-4">
					<div class="rounded-full p-5 bg-green-600"><i class="fa fa-wallet fa-2x fa-inverse"></i></div>
				</div>
				<div class="flex-1 text-right md:text-center">
					<h5 class="font-bold uppercase text-gray-600">Total Invoiced</h5>
					<h3 class="font-bold text-3xl">${{ $invoices->sum('amount') }}</h3>
				</div>
			</div>
		</div>
		<!--/Metric Card-->
	</div>
	<div class="w-full md:w-1/2 xl:w-1/3 p-3">
		<!--Metric Card-->
		<div class="bg-orange-100 border-b-4 border-orange-500 rounded-lg shadow-lg p-5">
			<div class="flex flex-row items-center">
				<div class="flex-shrink pr-4">
					<div class="rounded-full p-5 bg-orange-600"><i class="fas fa-users fa-2x fa-inverse"></i></div>
				</div>
				<div class="flex-1 text-right md:text-center">
					<h5 class="font-bold uppercase text-gray-600">Paid to Date</h5>
					<h3 class="font-bold text-3xl">${{ $payments }}</h3>
				</div>
			</div>
		</div>
		<!--/Metric Card-->
	</div>
	<div class="w-full md:w-1/2 xl:w-1/3 p-3">
		<!--Metric Card-->
		<div class="bg-yellow-100 border-b-4 border-yellow-600 rounded-lg shadow-lg p-5">
			<div class="flex flex-row items-center">
				<div class="flex-shrink pr-4">
					<div class="rounded-full p-5 bg-yellow-600"><i class="fas fa-user-plus fa-2x fa-inverse"></i></div>
				</div>
				<div class="flex-1 text-right md:text-center">
					<h5 class="font-bold uppercase text-gray-600">Open Balance</h5>
					<h3 class="font-bold text-3xl">${{ $invoices->sum('balance') }}</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="w-full p-3">
		<!--Metric Card-->
		<div class="bg-blue-100 border-b-4 border-blue-600 rounded-lg shadow-lg p-5">
			<h5 class="font-bold uppercase text-gray-600 text-center">Invoices</h5>
			<div class="py-2">
				<div class="w-full rounded overflow-hidden shadow-lg bg-white">
					<div class="px-6 py-4">
						{{$dataTable->table()}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



@endsection
@push('footerScripts')
  {{$dataTable->scripts()}}
  <script type="text/javascript">
    
  </script>
@endpush