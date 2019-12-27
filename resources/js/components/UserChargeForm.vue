<template>
    <div>
        <form @submit.prevent="submitStep">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="p-4 w-1/4">
                        <label class="form-label">Card Number</label>
                        <input v-model="form.cardNumber" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text">
                    </div>
                    <div class="p-4 w-1/4">
                        <label class="form-label">CVV</label>
                        <input v-model="form.cardCode" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text">
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="p-4 w-1/4">
                        <label class="form-label">Expire Month</label>
                        <input v-model="form.expMonth" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text">
                    </div>
                    <div class="p-4 w-1/4">
                        <label class="form-label">Expire Year</label>
                        <input v-model="form.expYear" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="text">
                    </div>
                    <input v-model="form.opaqueDataDescriptor" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="hidden">
                    <input v-model="form.opaqueDataValue" class="form-input leading-tight focus:outline-none focus:shadow-outline" type="hidden">
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
                // Set up authorisation to access the gateway.
                var authData = {};
                    authData.clientKey = "YOUR PUBLIC CLIENT KEY";
                    authData.apiLoginID = "YOUR API LOGIN ID";

                // Capture the card details from the payment form.
                // The cardCode is the CVV.
                // You can include fullName and zip fields too, for added security.
                // You can pick up bank account fields in a similar way, if using
                // that payment method.
                var cardData = {};
                    cardData.cardNumber = document.getElementById("cardNumber").value;
                    cardData.month = document.getElementById("expMonth").value;
                    cardData.year = document.getElementById("expYear").value;
                    cardData.cardCode = document.getElementById("cardCode").value;

                // Now send the card data to the gateway for tokenisation.
                // The responseHandler function will handle the response.
                var secureData = {};
                    secureData.authData = authData;
                    secureData.cardData = cardData;
                Accept.dispatchData(secureData, responseHandler);
            }
        },
        mounted: function () {
            let acceptJs = document.createElement('script');
            acceptJs.setAttribute('src', 'https://jstest.authorize.net/v1/Accept.js');
            document.head.appendChild(acceptJs);
        }
    }
</script>
