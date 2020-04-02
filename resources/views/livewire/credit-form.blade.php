<div>
	<div class="p-5">
        <div class="flex items-center">
            <div class="w-1/2 p-4">
                <label class="form-label">Client</label>
                <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="client_id" value="{{$credit->client_id ?? 0}}">
                	<option value="0">...</option>
                	@foreach($clients as $client)
                		<option value={{$client->id}}>{{$client->name}}</option>
                	@endforeach
                </select>
            </div>
        </div>
        <div class="flex items-center">
            <div class="p-4 w-1/4">
                <label class="form-label">Credit Date</label>
                <input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="date" wire:model.lazy="credit_date">
            </div>
            <div class="p-4 w-1/4">
                <label class="form-label">Completed</label>
                <input wire:change="completedChecked()" type="checkbox" {{$completed==0 ? '' : 'checked'}}>
            </div>
        </div>
        <div class="flex items-center">
            <div class="p-4 w-1/4">
                <label class="form-label">Amount</label>
                <input wire:model.lazy="amount" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text">
            </div>
            @if($creditCheck)
				<div class="p-4 w-1/4">
	                <label class="form-label">Balance</label>
	                <input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text" wire:model.lazy="balance">
	            </div>
            @endif
        </div>
        <div class="flex items-center">
            <div class="w-1/2 p-4">
                <label class="form-label">Notes</label>
                <input wire:model.lazy="notes" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text">
            </div>
        </div>
    </div>
    <div class="text-right p-3">
    <button class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" wire:click="submit()">
        {{ $creditCheck ? 'Update' : 'Submit' }}
    </button>
    </div>
</div>
