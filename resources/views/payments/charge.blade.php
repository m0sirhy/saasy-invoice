@extends('layouts.app')
@section('title', 'Charge Card')
@section('content')


<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('credits') }}">Payments</a> / New Payment</h3>
</div>
<div class="flex flex-wrap">
    <div class="leading-loose">
      <form class="max-w-xl m-4 p-10 bg-white rounded shadow-xl" method="POST" action="/charge/card" id="paymentForm">
        @csrf
        <div class="">
          <label class="hidden text-sm text-gray-00" for="name">Name on Card</label>
          <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="name" name="name" type="text" required value="{{ $invoice->Client->name ?? '' }}" aria-label="Name">
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
          #{{ $invoice->id ?? rand(1,1000) }}
        </div>
        <div class="inline-block mt-4 -mx-1 pl-1 w-1/2">
          <label class="block text-sm text-gray-600" for="amount">Amount</label>
          $0.50
        </div>
        <input type="hidden" name="amount" value="0.5" id="amount" />
        <input type="hidden" name="dataValue" id="dataValue" />
        <input type="hidden" name="dataDescriptor" id="dataDescriptor" />
        <div class="mt-4">
          <button  onclick="sendPaymentDataToAnet()" class="px-4 py-1 text-white font-light tracking-wider bg-green-900 rounded" type="button">Submit Payment</button>
        </div>
      </form>
    </div>
</div>
<script type="text/javascript" src="https://js.authorize.net/v1/Accept.js" charset="utf-8"></script>
<script type="text/javascript">
    function sendPaymentDataToAnet() {
        var authData = {};
            authData.clientKey = "8dnc35vzqDQ4nwfWhr96N7JhU4DQLFYtmu26Zf7BEsXCEX4sesADX623w83f2jm4";
            authData.apiLoginID = "6Ux8Sw4m";
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

    function responseHandler(response) {
        console.log(response)
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
        console.log()
        document.getElementById("dataDescriptor").value = opaqueData.dataDescriptor;
        document.getElementById("dataValue").value = opaqueData.dataValue;
        document.getElementById("number").value = "";
        document.getElementById("expire").value = "";
        document.getElementById("cvc").value = "";
        document.getElementById("name").value = "";
        document.getElementById("paymentForm").submit();
    }
</script>
@endsection
