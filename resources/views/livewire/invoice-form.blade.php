<div>
	<div class="px-5">
		<div class="flex items-center">
			<div class="w-1/2 p-4">
				<div class="mb-4">
					<label class="form-label">Client</label>
					<select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="clientId">
                        <option value="0">...</option>
		        	 	@foreach ($clients as $client)
				          	<option value="{{$client->id}}"> {{ $client->name }} - {{$client->email}} </option>
			          	@endforeach
			        </select>
			        <p class="text-right"><a class="text-blue-700" href="/clients/create">Create Client</a></p>
				</div>
				<div class="mb-4">
					<label class="form-label">Invoice Status</label>
					<select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="status">
                        @foreach ($invoiceStatuses as $invoiceStatus)
							<option value="{{$invoiceStatus->id}}">{{$invoiceStatus->status}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="w-1/2 p-4">
				<div class="flex items-center">
					<div class="w-1/2 p-4">
						<div class="mb-10">
							<label class="form-label">Invoice Date</label>
							<input class="form-input leading-tight focus:outline-none focus:shadow-outline" value="{{$invoiceDate}}" type="date" wire:model="invoiceDate">
						</div>
						<div class="mb-4">
                            <label class="form-label">Due Date</label>
                            <input class="form-input leading-tight focus:outline-none focus:shadow-outline" value="dueDate" type="date" wire:model="dueDate">
                        </div>
					</div>
					<div class="w-1/2">
						<div class="mb-10">
							<label class="form-label">Start Date</label>
                            <input class="form-input leading-tight focus:outline-none focus:shadow-outline" value="startDate" type="date" wire:model="startDate">
						</div>
						<div class="mb-4">
	                        <label class="form-label">End Date</label>
	                        <input class="form-input leading-tight focus:outline-none focus:shadow-outline" value="endDate" type="date" wire:model="endDate">
	                    </div>
					</div>
				</div>
			</div>
		</div>
		<table class="table-auto w-full">
            <thead class="bg-orange-100 border-b-4 border-orange-600 rounded-lg">
                <tr>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2 w-1/6">Unit Price</th>
                    <th class="px-4 py-2 w-1/6">Quantity</th>
                    <th class="px-4 py-2"></th>
                    <th class="px-4 py-2 border-l-8 border-white">Line Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr class="item">
                        <td class="p-1"><select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$item['product_id']}}"wire:model="items.{{$loop->index}}.product_id" :key="{{$item['id']}}">
                            <option value="0">...</option>
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select></td>
                        <td class="p-1"><input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text" value="{{$item['description']}}" wire:model="items.{{$loop->index}}.description" :key="{{$item['id']}}"/></td>
                        <td class="p-1"><input class="form-input leading-tight text-right focus:outline-none focus:shadow-outline" type="number" value="{{$item['unit_price']}}" wire:model="items.{{$loop->index}}.unit_price" :key="{{$item['id']}}"/></td>
                        <td class="p-1"><input class="form-input leading-tight text-right focus:outline-none focus:shadow-outline" type="number" value="{{$item['quantity']}}" wire:model="items.{{$loop->index}}.quantity" :key="{{$item['id']}}"/></td>
                        <td class="text-center"><a wire:click="removeRow({{$item['id']}}, {{$loop->index}})"><i class="fa fa-times text-red-700"></i></a>
                        <td class="text-center">${{ number_format($item['unit_price'] * $item['quantity'], 2) }}</td>
                    </tr>
                @endforeach
        		<tr>
                    <td colspan="4 pt-4">
                        <button type="button" class="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded inline-flex items-center" wire:click="addRow">
                            <i class="fa fa-plus pr-0 md:pr-3"></i>
                            <span>Add Row</span>
                        </button>
                    </td>
                </tr>
                <tr class="total">
                <td colspan="4"></td>
                <td colspan="2" class="text-xl"><hr>Total: ${{ number_format($total, 2) }}</td>
	            </tr>
	            <tr class="total">
                    <td colspan="4"></td>
                    <td colspan="2" class="text-xl"><hr>Balance: ${{ number_format($balance, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <label class="form-label" for="mail"><input type="checkbox" id="mail" wire:model="mail" wire:click="mailChecked()" {{$mail == 0 ? '' : 'checked'}}>Mail Invoice</label>
        <div class="flex items-center">
            <div class="w-1/2 p-4">
                <label class="form-label pt-5" for="public_notes">
                <h3>Public Notes:</h3>
                </label>
                <textarea wire:model="publicNotes" class="form-input leading-tight focus:outline-none focus:shadow-outline" id="public_notes"></textarea>
            </div>
            <div class="w-1/2 p-4">
                <label class="form-label pt-5" for="private_notes">
                <h3>Private Notes:</h3>
                </label>
                <textarea wire:model="privateNotes" class="form-input leading-tight focus:outline-none focus:shadow-outline" id="private_notes"></textarea>
            </div>
        </div>
        <div class="text-right p-3">
            @if($invoiceCheck)
                <button class="bg-blue-800 text-sm hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" wire:click="update()">
                    Update
                </button>
                <a href="{{ route('invoice.download', ['invoice' => $invoiceId]) }}"><button class="bg-blue-800 text-sm hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" type="button"><i class="fa fa-download"></i> Download</button></a>
            @else
                <button class="bg-blue-800 text-sm hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" wire:click="create()">
                    Create
                </button>
            @endif
        </div>
	</div>
</div>
