/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue');
import vSelect from 'vue-select'

Vue.component('invoice-form', require('./components/InvoiceForm.vue').default);
Vue.component('commission-form', require('./components/CommissionForm.vue').default);
Vue.component('credit-form', require('./components/CreditForm.vue').default);
Vue.component('payment-form', require('./components/PaymentForm.vue').default);
Vue.component('billing-form', require('./components/BillingForm.vue').default);

Vue.component('v-select', vSelect);

const app = new Vue({
    el: '#app',
});
