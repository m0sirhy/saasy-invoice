<template>
    <div>
        <form @submit.prevent="submitStep">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="w-1/2 p-4">
                        <label class="form-label">Client</label>
                        <v-select
                            v-model="form.client_id"
                            :reduce="client_id => client_id.id"
                            :options="clients"
                            @input="getInvoices"
                        ></v-select>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="p-4 w-1/4">
                        <label class="form-label">Invoice</label>
                        <v-select v-model="form.invoice_id" :reduce="invoice_id => invoice_id.id" :options="invoices"></v-select>
                    </div>
                    <div class="p-4 w-1/4">
                        <label class="form-label">Payment Type</label>
                        <v-select v-model="form.payment_type" :options="types"></v-select>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="p-4 w-1/4">
                        <label class="form-label">Amount</label>
                        <input v-model="form.amount" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text">
                    </div>
                    <div class="p-4 w-1/4">
                        <label class="form-label">Auth Code/Check #</label>
                        <input v-model="form.auth_code" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text">
                    </div>
                </div>
                <div class="flex item-center">
                    <div class="p-4 w-1/4">
                        <label class="form-label">Payment Date</label>
                        <input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="date" v-model="form.payment_at">
                    </div>
                </div>
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
        props: ['paymentModel', 'paymentTypes', 'url'],
        data() {
            return {
                clients: [{label: '', id: null}],
                invoices: [{label: '', id: null}],
                types: JSON.parse(this.paymentTypes),
                form: {
                    user_id: '',
                    invoice_id: '',
                    payment_at: new Date().toISOString().slice(0,10),
                    amount: '',
                    payment_type: '',
                    auth_code: ''
                }
            }
        },
        methods: {
            submitStep: function (e) {
                e.preventDefault();
                this.errors = [];
                var self = this;
                let params = Object.assign({}, self.form);
                if (!this.errors.length) {
                    axios.post(this.url, params).then(response => {
                        window.location.href = '/payments';
                    }).catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        }
                    });
                }
            },
            getInvoices: function (e) {
                var self = this;
                self.invoices = []
                axios.get('/api/invoice/client/' + e)
                .then(function(response) {
                    $.each(response.data, function(key, data)  {
                        self.invoices.push({label: '#' + data.id + ' $' + data.balance, id: data.id})
                    })
                });
            }
        },
        filters: {
            currency(value) {
                return value.toFixed(2);
            }
        },
        mounted: function () {
            var self = this;
            axios.get('/api/clients')
            .then(function(response) {
                $.each(response.data, function(key, data)  {
                    self.clients.push({label: data.name + ' <' + data.email + '>', id: data.id})
                })
            });
            if (this.paymentModel !== '') {
                this.form = JSON.parse(this.paymentModel);
                this.form.payment_at = JSON.parse(this.paymentModel).payment_at;
            }
        }
    }
</script>
