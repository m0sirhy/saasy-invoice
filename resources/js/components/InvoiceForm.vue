<template>
	<div>
		<form @submit.prevent="submitStep">
			<div class="px-5">
				<div class="flex items-center">
					<div class="w-1/2 p-4">
						<div class="mb-4">
							<label class="form-label">Client</label>
							<v-select v-model="form.client_id" :reduce="client_id => client_id.id" :options="clients"></v-select>
							<p class="text-right"><a class="text-blue-700" href="/clients/create">Create Client</a></p>
						</div>
						<div class="mb-4">
							<label class="form-label">Invoice Status</label>
							<v-select  v-model="form.invoice_status_id" :reduce="invoice_status_id => invoice_status_id.id" :options="statuses"></v-select>
						</div>
					</div>
					<div class="w-1/2 p-4">
						<div class="flex items-center">
							<div class="w-1/2 p-4">
								<div class="mb-4">
									<label class="form-label">Invoice Date</label>
									<input v-model="form.invoice_date" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="date">
								</div>
								<div class="mb-4">
									<label class="form-label">Due Date</label>
									<input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="date" v-model="form.due_date">
								</div>
							</div>
							<div class="w-1/2">
								<div class="mb-4">
									<label class="form-label">End Date</label>
									<input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="date" v-model="form.end_date">
								</div>
								<div class="mb-4">
									<label class="form-label">Start Date</label>
									<input v-model="form.start_date" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="date">
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
						<tr class="item" v-for="(item, index) in items">
							<td class="p-1"><v-select v-model="item.product_id" :reduce="product_id => product_id.id" :options="products" @input="populate"></v-select></td>
							<td class="p-1"><input class="form-input leading-tight focus:outline-none focus:shadow-outline" v-model="item.description" /></td>
							<td class="p-1"><input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="number" step="0.01" min="0" v-model="item.unit_price" /></td>
							<td class="p-1"><input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="number" min="0" v-model="item.quantity" /></td>
							<td class="text-center"><a @click="removeRow(index)"><i class="fa fa-times text-red-700"></i></a></td>
							<td class="text-center">${{ item.unit_price * item.quantity | currency }}</td>
						</tr>

						<tr>
							<td colspan="4 pt-4">
								<button type="button" class="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded inline-flex items-center" @click="addRow">
									<i class="fa fa-plus pr-0 md:pr-3"></i>
									<span>Add Row</span>
								</button>
							</td>
						</tr>
						<tr class="total">
							<td colspan="5"></td>
							<td class="text-xl"><hr>Total: ${{ total | currency }}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="text-right p-3">
				<button class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
					<slot>Submit</slot>
				</button>
			</div>
		</form>
	</div>
</template>

<script>
	import 'vue-select/dist/vue-select.css';
	export default {
		props: ['invoiceModel', 'itemsModel', 'url'],
		data() {
			return {
				items: [
					{id: 0, description: "", quantity: 0, unit_price: 0, name: '', product_id: 0}
				],
				products: [{name: '', id: 0, unit_price: 0, notes: '', label: ''}],
				clients: [{label: '', id: null}],
				statuses: [
					{label: 'Draft', id: 1},
					{label: 'Sent', id: 2},
					{label: 'Viewed', id: 3},
					{label: 'Unpaid', id: 4},
					{label: 'Over Due', id: 5},
					{label: 'Paid', id: 6}
				],
				form: {
					client_id: '',
					invoice_date: '',
					due_date: '',
					invoice_status_id: '',
					start_date: '',
					end_date: '',
					id: 0
				},
			}
		},
		computed: {
			total() {
				let total = this.items.reduce(
					(acc, item) => acc + item.unit_price * item.quantity,
					0
					);
				this.form.total = total
				return total
			}
		},
		methods: {
			addRow() {
				this.items.push({id: 0, description: "", quantity: 0, unit_price: 0, name: '', product_id: 0});
			},
			removeRow(index) {
				this.items.splice(index, 1);
			},
			populate(event) {
				var item = this.items.find(item => item.product_id === event)
				var product = this.products.find(product => product.id === event)
				item.unit_price = product.unit_price
				item.quantity = 1
				item.description = product.notes
				item.name = product.name
			},
			submitStep: function (e) {
				e.preventDefault();
				this.errors = [];
				var self = this;
				let params = Object.assign({}, self.form, {items: self.items});
				if (!this.errors.length) {
					axios.post(this.url, params).then(response => {
						if (response.data.status === 200) {
							window.location.href = '/invoices';
						}
					}).catch(error => {
						console.log(this.errors);
						if (error.response.status === 422) {
							this.errors = error.response.data.errors || {};
						}
					});
				}
				
			}
		},
		filters: {
			currency(value) {
				return value.toFixed(2);
			}
		},
		mounted: function () {
			var self = this;
			axios.get('/api/products')
			.then(function(response) {
				response.data.map(function(data, key) {
					self.products.push(
						{
							name: data.name,
							id: data.id,
							unit_price: data.unit_price,
							notes: data.notes,
							label: data.name
						}
					)
				});
			});
			axios
			.get('/api/clients')
			.then(function(response) {
				$.each(response.data, function(key, data)  {
					self.clients.push({label: data.name, id: data.id})
				})
			});
			if (this.invoiceModel !== '' && this.itemsModel !== '') {
				this.form = JSON.parse(this.invoiceModel);
				this.items = JSON.parse(this.itemsModel);
			}
		}
	}
</script>