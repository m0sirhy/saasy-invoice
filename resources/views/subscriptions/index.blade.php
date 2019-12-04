@extends('layouts.app')

@section('content')

<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2">Subscriptions</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Subscriptions</h5> 
            </div>
            <div class="p-5">
              <a href="{{ route('subscription.create') }}">
              <button class="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fa fa-plus pr-0 md:pr-3"></i>
                <span>New Subscription</span>
              </button>
	          </a>
			<div class="flex flex-wrap">
			    <div class="w-full md:w-1/2 xl:w-full p-5">
			        <div class="bg-white border-transparent rounded-lg shadow-lg">
			            <div class="p-5">
						  {{$dataTable->table()}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection

@push('footerScripts')
    {{$dataTable->scripts()}}
@endpush