@extends('layouts.client')

@section('title', 'Make a Payment')

@section('content')
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2">Make a Payment</h3>
</div>
<div class="flex flex-wrap" id="app">
    <div class="w-full md:w-1/2 xl:w-1/3 p-3">
        
    </div>
    <div class="w-full md:w-1/2 xl:w-1/3 p-3">
        <!--Metric Card-->
        <div class="bg-blue-100 border-b-4 border-blue-600 rounded-lg shadow-lg p-5 items-center">
            <h5 class="font-bold uppercase text-gray-600 text-center">Payment Details</h5>
            <div class="py-2">
                <div class="w-full rounded overflow-hidden shadow-lg bg-white">
                    <div class="px-6 py-4">
                      {!! Form::model($invoice, ['route' => ['client.invoice.payment', 'invoice' => $invoice->id], 'id' => 'paymentForm']) !!}
                        <div class="">
                          <label class="hidden text-sm text-gray-00" for="name">Name on Card</label>
                          <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="name" name="name" type="text" required value="{{ $invoice->Client->name }}" aria-label="Name">
                        </div>
                        <div class="mt-2">
                          <label class="hidden text-sm text-gray-600" for="number">Card Number</label>
                          <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="number" name="number" type="text" required="" placeholder="Card Number" aria-label="Number">
                        </div>
                        <div class="inline-block mt-2 w-1/2 pr-1">
                          <label class="hidden block text-sm text-gray-600" for="expire">Expiration</label>
                          <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="expire" name="expire" type="text" required="" placeholder="MM/YYYY" aria-label="Expiration">
                        </div>
                        <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
                          <label class="hidden block text-sm text-gray-600" for="cvc">CVC</label>
                          <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="cvc"  name="cvc" type="text" required="" placeholder="CVC" aria-label="cvc">
                        </div>
                        <div class="inline-block mt-4 w-1/2 pr-1">
                          <label class="block text-sm text-gray-600" for="invoice">Invoice</label>
                          #{{ $invoice->id }}
                        </div>
                        <div class="inline-block mt-4 -mx-1 pl-1 w-1/2">
                          <label class="block text-sm text-gray-600" for="amount">Amount</label>
                          ${{ money_format('%i', $invoice->balance) }}
                        </div>
                        <input type="hidden" name="invoice" value="{{ $invoice->id }}" id="invoice" />
                        <input type="hidden" name="amount" value="{{ $invoice->balance }}" id="amount" />
                        <input type="hidden" name="dataValue" id="dataValue" />
                        <input type="hidden" name="dataDescriptor" id="dataDescriptor" />
                        <div class="mt-4">
                          <button  onclick="sendPaymentDataToAnet()" class="px-4 py-1 text-white font-light tracking-wider bg-green-900 rounded" type="button">Submit Payment</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://js.authorize.net/v1/Accept.js" charset="utf-8"></script>
<script type="text/javascript">
    function sendPaymentDataToAnet() {
        var authData = {};
            authData.clientKey = "8dnc35vzqDQ4nwfWhr96N7JhU4DQLFYtmu26Zf7BEsXCEX4sesADX623w83f2jm4";
            authData.apiLoginID = "6Ux8Sw4m";
        if (validateCard()) {
            var expire = document.getElementById("expire").value.split('/');
            var cardData = {};
                cardData.cardNumber = document.getElementById("number").value;
                cardData.month = expire[0];
                cardData.year = expire[1];
                cardData.cardCode = document.getElementById("cvc").value;
            var secureData = {};
                secureData.authData = authData;
                secureData.cardData = cardData;
            Accept.dispatchData(secureData, responseHandler);
        }
    }

    function responseHandler(response) {
        if (response.messages.resultCode === "Error") {
            var i = 0;
            while (i < response.messages.message.length) {
                console.log(
                    response.messages.message[i].code + ": " +
                    response.messages.message[i].text
                );
                i = i + 1;
            }
        } else {
            paymentFormUpdate(response.opaqueData);
        }
    }

    function paymentFormUpdate(opaqueData) {
        document.getElementById("dataDescriptor").value = opaqueData.dataDescriptor;
        document.getElementById("dataValue").value = opaqueData.dataValue;
        document.getElementById("number").value = "";
        document.getElementById("expire").value = "";
        document.getElementById("cvc").value = "";
        document.getElementById("name").value = "";
        document.getElementById("paymentForm").submit();
    }

    //Basic Card Validation before posting
    function validateCard() {
        var expire = document.getElementById("expire").value;
        var cvc = document.getElementById("cvc").value;
        var number = document.getElementById("number").value;
        // console.log(expire);
        if (!expire.includes('/')) {
            alert('Your Expiration Date Does Not Include A /');
            return false;
        }
        expire = expire.split('/');
        if (expire[0].length != 2) {
            alert('You Must Use 2 Digits For Your Month');
            return false;
        }
        if (isNaN(expire[0])) {
            alert('Your Month Is Not A Number');
            return false;
        }
        if (parseInt(expire[0]) > 12 || parseInt(expire[0]) < 0) {
            alert('You Inputed An Invalid Month');
            return false;
        }
        if (expire[1].length != 4) {
            alert('You Must Use 4 Digits For Your Year');
            return false;
        }
        if (isNaN(expire[1])) {
            alert('Your Year Is Not A Number');
            return false;
        }
        if (cvc.length != 3 && cvc.length != 4) {
            alert('Your CVC is invalid');
            return false;
        }

        if (!luhnAlgorithm(number)) {
            alert('Your Credit Card Is Invalid');
            return false;
        }
        return true;
    }
    function luhnAlgorithm(value) {
        if (/[^0-9-\s]+/.test(value)) {
            return false;
        }
        let nCheck = 0;
        let bEven = false;
        value = value.replace(/\D/g, "");

        for (var n = value.length-1; n >= 0; n--) {
            var cDigit = value.charAt(n);
            var nDigit = parseInt(cDigit, 10);

            if (bEven && (nDigit *= 2) > 9) {
                nDigit -=9;
            }
            nCheck += nDigit;
            bEven = !bEven;
        }

        return (nCheck % 10) == 0;
    }
</script>

@endsection
