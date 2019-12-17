<template>
    <div>
        <form @submit.prevent="submitStep">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="w-1/2 p-4">
                        <label class="form-label">Client</label>
                        <v-select v-model="form.client_id" :reduce="client_id => client_id.id" :options="clients"></v-select>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="p-4 w-1/4">
                        <label class="form-label">Credit Date</label>
                        <input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="date" v-model="form.credit_date">
                    </div>
                    <div class="p-4 w-1/4">
                        <label class="form-label">Completed</label>
                        <input v-model="form.completed" type="checkbox">
                    </div>
                    
                </div>
                <div class="flex items-center">
                    <div class="p-4 w-1/4">
                        <label class="form-label">Amount</label>
                        <input v-model="form.amount" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text">
                    </div>
                    <div class="p-4 w-1/4" v-if="this.creditModel !== ''">
                        <label class="form-label">Balance</label>
                        <input class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text" v-model="form.balance">
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-1/2 p-4">
                        <label class="form-label">Notes</label>
                        <input v-model="form.notes" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text">
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
        props: ['creditModel', 'url'],
        data() {
            return {
                clients: [{label: '', id: null}],
                form: {
                    user_id: '',
                    credit_date: new Date().toISOString().slice(0,10),
                    amount: '',
                    balance: '',
                    completed: '',
                    notes: ''
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
                        console.log(response.data.status);
                        if (response.data.status === 200) {
                            window.location.href = '/credits';
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
            axios.get('/api/clients')
            .then(function(response) {
                $.each(response.data, function(key, data)  {
                    self.clients.push({label: data.name + ' <' + data.email + '>', id: data.id})
                })
            });
            if (this.creditModel !== '') {
                this.form = JSON.parse(this.creditModel);
            }
        }
    }
</script>
