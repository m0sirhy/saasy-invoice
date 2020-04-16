<div>
    <div class="px-5">
        <div class="flex items-center">
            <div class="w-1/2 p-4">
                <div class="mb-4">
                    @livewire('client-picker', ['clientId' => $clientId ?? null])
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
                            <input class="form-input leading-tight focus:outline-none focus:shadow-outline" value="{{-- {{$invoiceDate}} --}}" type="date" wire:model="invoiceDate">
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
        </div>

        <div
            x-data="invoice({{$invoiceId ?? 0}})"
            x-init="getData({{$invoiceId ?? 0}}, {{$balance ?? 0}})"
            x-cloak
        >
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
            <template x-for="item in items" :key="item">
                <tr>
                    <td class="p-1">
                        <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        :value="item.product_id"
                        x-model="item.product_id"
                        x-on:input="productUpdated(item.id, $event.target.value)"
                        >
                            <option :value="item.product_id" x-text="item.name"></option>
                            <template x-for="product in products">
                                <option :key="product.id" :value="product.id" x-text="product.name">
                                </option>
                            </template>
                        </select>
                    </td>
                    <td class="p-1"><input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text" x-model="item.description"></td>
                    <td class="p-1"><input class="form-input leading-tight text-right focus:outline-none focus:shadow-outline" type="number" x-model="item.unit_price" x-on:change="computeLine(item)"></td>
                    <td class="p-1"><input class="form-input leading-tight text-right focus:outline-none focus:shadow-outline" type="number" x-model="item.quantity" x-on:change="computeLine(item)"></td>
                    <td class="text-center"><button x-on:click="deleteItem(item.id)"><i class="fa fa-times text-red-700 py-2 px-3 focus:outline-none"></i></button></td>
                    <td class="text-center" x-text="numberFormat(item.total)"></td>
                </tr>
            </template>
            <tr>
                <td colspan="4 pt-4">
                    <button type="button" class="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded inline-flex items-center" x-on:click="addItem">
                        <i class="fa fa-plus pr-0 md:pr-3"></i>
                        <span>Add Row</span>
                    </button>
                </td>
            </tr>
            <tr class="total">
                <td colspan="4"></td>
                <td colspan="2" class="text-xl"><hr>Total: <span class="text-xl" x-text="netTotal"></span></td>
                </tr>
                <tr class="total">
                    <td colspan="4"></td>
                    <td colspan="2" class="text-xl"><hr>Balance: <span class="text-xl" x-text="numberFormat(netBalance)"></span></td>
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
                <button class="bg-blue-800 text-sm hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" x-on:click="updateInvoice()">
                    Update
                </button>
                <a href="{{ route('invoice.download', ['invoice' => $invoiceId]) }}"><button class="bg-blue-800 text-sm hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" type="button"><i class="fa fa-download"></i> Download</button></a>
            @else
                <button class="bg-blue-800 text-sm hover:bg-blue-700 text-white font-bold py-1 px-3 rounded" x-on:click="createInvoice()">
                    Create
                </button>
            @endif
        </div>
        </div>
    </div>
</div>
@push('alpineScripts')
<script>
function invoice(id) {
    return {
        products: [
            
        ],

        items: [
        ],

        invoiceNumber: 0,
        invoiceDate: '',
        invoiceDueDate: '',

        netTotal: 0,
        netBalance: 0,
        

        defaultItem: {
            id: '',
            product_id: '',
            invoice_id: id,
            quantity: 0,
            description: '',
            name: '',
            unit_price: 0,
            total: 0
        },

        billing: {
            name: '',
            address: '',
            extra: ''
        },
        from: {
            name: '',
            address: '',
            extra: ''
        },

        showTooltip: false,
        showTooltip2: false,
        openModal: false,

        getData(id, balance) {
            var self = this;
            fetch(`/api/products`)
                .then(res => res.json())
                .then(data => {
                    data.map(function(data, key) {
                        self.products.push(
                            {
                                id: data.id,
                                name: data.name,
                                unit_price: data.unit_price,
                                notes: data.notes,
                                label: data.name
                            }
                        )
                    });
                }
            );
            fetch(`/api/invoice/items/` + id)
                .then(res => res.json())
                .then(data => {
                    data.map(function(data, key) {
                        self.items.push(
                            {
                                id: data.id,
                                product_id: data.product_id,
                                invoice_id: data.invoice_id,
                                quantity: data.quantity,
                                description: data.description,
                                name: data.name,
                                unit_price: data.unit_price,
                                total: data.unit_price * data.quantity
                            }
                        )
                    });
                    self.itemTotal();
                });
            self.netBalance = balance;
        },

        addItem() {
            this.items.push({
                id: this.generateUUID(),
                product_id: this.defaultItem.product_id,
                invoice_id: this.defaultItem.invoice_id,
                quantity: 0,
                description: '',
                name: '',
                unit_price: 0,
                total: 0
            });

            this.itemTotal();
        },

        deleteItem(uuid) {
            item = this.items.filter(function(item) {
                return item.id == uuid;
            });
            this.netBalance = this.netBalance - item[0].total;
            this.items = this.items.filter(function(item){
                return item.id != uuid;
            });
            this.itemTotal();
        },

        computeLine(item) {
            currentTotal = item.total;
            item.total = item.unit_price * item.quantity;
            this.netBalance += item.total - currentTotal;
            this.itemTotal();
        },

        itemTotal() {
            this.netTotal = this.numberFormat(this.items.length > 0 ? this.items.reduce((result, item) => {
                return result + (item.total);
            }, 0) : 0);
        },

        itemTotalGST() {
            this.totalGST =  this.numberFormat(this.items.length > 0 ? this.items.reduce((result, item) => {
                return result + (item.total);
            }, 0) : 0);
        },

        productUpdated(uuid, value) {
            item = this.items.filter(function(item) {
                return item.id == uuid;
            });
            prod = this.products.filter(function(product) {
                return product.id == value; 
            });
            item[0].name = prod[0].name;
            item[0].description = prod[0].notes;
            item[0].unit_price = prod[0].unit_price;
            this.computeLine(item[0]);
        },

        calculateGST(GSTPercentage, itemRate) {
            return this.numberFormat((itemRate - (itemRate * (100 / (100 + GSTPercentage)))).toFixed(2));
        },

        generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        },

        numberFormat(amount) {
            return amount.toLocaleString("en-US", {
                style: "currency",
                currency: "USD"
            });
        },

        printInvoice() {
            var printContents = this.$refs.printTemplate.innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        },

        updateInvoice() {
            window.livewire.emit('update', this.items, this.netTotal, this.netBalance);
        },

        createInvoice() {
            window.livewire.emit('create', this.items, this.netTotal, this.netBalance);
        }
    }
}

</script>
@endpush