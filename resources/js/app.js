/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');
import vSelect from 'vue-select'

Vue.component('invoice-form', require('./components/InvoiceForm.vue').default);
Vue.component('v-select', vSelect);
const app = new Vue({
    el: '#app',
});
