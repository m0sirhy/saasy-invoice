<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="flex items-center">
        <div class="w-1/2 p-4">
            <label class="form-label">Client</label>
            <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="clientText">
        	 	@foreach($clients as $client)
		          	<option> {{ $client->name }} - {{$client->email}} </option>
	          	@endforeach
	        </select>
        </div>
    </div>
    <div class="flex items-center">
        <div class="p-4 w-1/4">
            <label class="form-label">Invoice</label>
            <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="invoiceId">
            	@foreach($invoices as $invoice)
            		<option>{{$invoice}}</option>
            	@endforeach
            </select>
        </div>
        <div class="p-4 w-1/4">
            <label class="form-label">Payment Type</label>
        	<select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="paymentType">
        	 	@foreach($types as $key => $type)
		          	<option value={{$key}}>{{ $type }}</option>
	          	@endforeach
	        </select>
        </div>
    </div>
    <div class="flex items-center">
    	<div class="p-4 w-1/4">
		    <label class="form-label">Amount</label>
			<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="amount" type="text" placeholder="Amount">
		</div>
		<div class="p-4 w-1/4">
            <label class="form-label">Auth Code/Check #</label>
            <input wire:model="authCode" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text">
        </div>
	</div>
	<div class="flex item-center">
        <div class="p-4 w-1/4">
            <label class="form-label">Payment Date</label>
            <input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="date" wire:model="paymentDate">
        </div>
    </div>
    <div class="text-right p-3">
        <button wire:click="submit" class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Submit
        </button>
    </div>
</div>
