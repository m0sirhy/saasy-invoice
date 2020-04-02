<div>
    <div class="px-5">
    	<div class="flex items-center">
            <div class="w-1/3 p-4">
                <div class="mb-4">
                    <label class="form-label">Name</label>
                    <input wire:model="name" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text">
                </div>
            </div>
            <div class="w-1/3 p-4">
                <div class="mb-4">
                    <label class="form-label">Monthly Fee</label>
                    <input class="form-input leading-tight focus:outline-none focus:shadow-outline"  type="number" step="0.01" min="0" wire:model="monthlyFee">
                </div>
            </div>
            <div class="w-1/3 p-4">
                <div class="mb-4">
                    <label class="form-label">Monthly Min</label>
                    <input class="form-input leading-tight focus:outline-none focus:shadow-outline"  type="number" step="0.01" min="0" wire:model="monthlyMin">
                </div>
            </div>
        </div>
        <table class="table-auto w-full">
            <thead class="bg-orange-100 border-b-4 border-orange-600 rounded-lg">
                <tr>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">CRM ID</th>
                    <th class="px-4 py-2">Unit Price</th>
                    <th class="px-4 py-2">After Min?</th>
                    <th class="px-4 py-2">Price After</th>

                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody>
            	{{--Figure out items--}}
                @foreach($items as $item)
                	<tr class="item">
                        <td class="p-1"><select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$item['product_id']}}" wire:model="items.{{$loop->index}}.product_id" :key="{{$item['id']}}">
                            <option value="0">...</option>
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select></td>

                        <td class="p-1"><input class="form-input leading-tight focus:outline-none focus:shadow-outline" wire:model="items.{{$loop->index}}.alt_id" /></td>

                        <td class="p-1"><input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="number" step="0.01" min="0" wire:model="items.{{$loop->index}}.price_per" /></td>

                        <td class="p-1"> <input type="checkbox" value="1" wire:model="items.{{$loop->index}}.after_min" /></td>

                        <td class="p-1"><input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="number" step="0.01" min="0" wire:model="items.{{$loop->index}}.price_after" /></td>

                        <td class="text-center"><a wire:click="removeRow({{$item['id']}}, {{$loop->index}})"><i class="fa fa-times text-red-700"></i></a></td>

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
            </tbody>
        </table>
    </div>
    <div class="text-right p-3">
        @if($billingCheck)
            <button class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" wire:click="update()">
                Update
            </button>
        @else
            <button class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" wire:click="create()">
                Create
            </button>
        @endif
    </div>
</div>
