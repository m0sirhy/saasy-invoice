<template>
    <div>
        <form @submit.prevent="submitStep">
            <div class="px-5">
                <div class="flex items-center">
                    <div class="w-1/3 p-4">
                        <div class="mb-4">
                            <label class="form-label">Name</label>
                            <input v-model="form.name" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text">
                        </div>
                    </div>
                    <div class="w-1/3 p-4">
                        <div class="mb-4">
                            <label class="form-label">Monthly Fee</label>
                            <input class="form-input leading-tight focus:outline-none focus:shadow-outline"  type="number" step="0.01" min="0" v-model="form.monthly_fee">
                        </div>
                    </div>
                    <div class="w-1/3 p-4">
                        <div class="mb-4">
                            <label class="form-label">Monthly Min</label>
                            <input class="form-input leading-tight focus:outline-none focus:shadow-outline"  type="number" step="0.01" min="0" v-model="form.monthly_min">
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
                        <tr class="item" v-for="(item, index) in items">
                            <td class="p-1"><v-select v-model="item.product_id" :reduce="product_id => product_id.id" :options="products" @input="populate"></v-select></td>

                            <td class="p-1"><input class="form-input leading-tight focus:outline-none focus:shadow-outline" v-model="item.alt_id" /></td>

                            <td class="p-1"><input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="number" step="0.01" min="0" v-model="item.unit_price" /></td>

                            <td class="p-1"> <input type="checkbox" value="1" v-model="item.after_min" /></td>

                            <td class="p-1"><input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="number" step="0.01" min="0" v-model="item.price_after" /></td>

                            <td class="text-center"><a @click="removeRow(index)"><i class="fa fa-times text-red-700"></i></a></td>

                        </tr>

                        <tr>
                            <td colspan="4 pt-4">
                                <button type="button" class="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded inline-flex items-center" @click="addRow">
                                    <i class="fa fa-plus pr-0 md:pr-3"></i>
                                    <span>Add Row</span>
                                </button>
                            </td>
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
        props: ['billingModel', 'itemsModel', 'url'],
        data() {
            return {
                items: [
                    {id: 0, price_after: 0, after_min: 0, unit_price: 0, alt_id: '', product_id: 0}
                ],
                products: [{name: '', id: 0, unit_price: 0, notes: '', label: ''}],
                form: {
                    name: '',
                    monthly_fee: 0,
                    monthly_min: 0,
                    id: 0
                },
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
                var item = this.items.find(item => item.product_id === event);
                var product = this.products.find(product => product.id === event);
                item.unit_price = product.unit_price;
                item.quantity = 1;
                item.description = product.notes;
                item.name = product.name;
            },
            submitStep: function (e) {
                e.preventDefault();
                this.errors = [];
                var self = this;
                let params = Object.assign({}, self.form, {items: self.items});
                if (!this.errors.length) {
                    axios.post(this.url, params).then(response => {
                        window.location.href = '/billings';
                    }).catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        }
                    });
                }
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

            if (this.billingModel !== '' && this.itemsModel !== '') {
                this.form = JSON.parse(this.billingModel);
                this.items = JSON.parse(this.itemsModel);
            }
        }
    }
</script>