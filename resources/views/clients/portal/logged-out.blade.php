@extends('layouts.client')

@section('title', 'Logged Out')

@section('content')

<div class="bg-blue-800 p-2 shadow text-xl text-white">
	<h3 class="font-bold pl-2">Logged out</h3>
</div>
<div class="flex flex-wrap h-auto justify-center">
	<div class="w-full md:w-1/2 xl:w-1/3 p-3">
		<!--Metric Card-->
		<div class="bg-green-100 border-b-4 border-green-600 rounded-lg shadow-lg p-5">
			<div class="flex flex-row items-center">
				
				<div class="flex-1 text-right md:text-center">
					<h3 class="font-bold uppercase text-gray-700">You are now logged out.  It is safe to close the window.</h5>
				</div>
			</div>
		</div>
		<!--/Metric Card-->
	</div>
</div>
@endsection
