@extends('layouts.app')
@section('title', 'Charge Card')
@section('content')


<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('credits') }}">Payments</a> / New Payment</h3>
</div>
<div class="flex flex-wrap">
    <div class="leading-loose">
        {!! Form::model($invoice, ['route' => ['payments.user.charge.card', 'invoice' => $invoice->id ?? ''], 'id' => 'paymentForm', 'class' => 'max-w-xl m-4 p-10 bg-white rounded shadow-xl']) !!}
        @csrf
        <div class="">
          <label class="hidden text-sm text-gray-00" for="name">Name on Card</label>
          <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="name" name="name" type="text" required placeholder="Name on Card" value="{{ $invoice->Client->name ?? '' }}" aria-label="Name">
        </div>
        <div class="mt-2">
          <label class="hidden text-sm text-gray-600" for="number">Card Number</label>
          <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="number" name="number" type="text" required=""  placeholder="Card Number" aria-label="Number" value={{$cardData['cardNumber']??''}}>
        </div>
        <div class="inline-block mt-2 w-1/2 pr-1">
          <label class="hidden block text-sm text-gray-600" for="expire">Expiration</label>
          <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="expire" name="expire" type="text" required="" placeholder="MM/YYYY" aria-label="Expiration" value={{$cardData['expirationDate'] ?? ''}}>
        </div>
        <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
          <label class="hidden block text-sm text-gray-600" for="cvc">CVC</label>
          <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="cvc"  name="cvc" type="text" required="" placeholder="CVC" aria-label="cvc">
        </div>
        @if (is_null($invoice->id))
            <div class="inline-block mt-4 w-full text-right">
                <label class="hidden block text-sm text-gray-600" for="email">E-Mail</label>
                <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="email"  name="email" type="text" required="" placeholder="E-Mail" aria-label="email">
            </div>
            <div class="inline-block mt-4 w-full text-right">
                <label class="hidden block text-sm text-gray-600" for="address">Address</label>
                <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="address"  name="address" type="text" required="" placeholder="Address" aria-label="address">
            </div>
            <div class="inline-block mt-2 -mx-1 pl-1 w-full">
                <label class="hidden block text-sm text-gray-600" for="city">City</label>
                <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="city"  name="city" type="text" required="" placeholder="City" aria-label="city">
            </div>
            <div class="inline-block mt-2 -mx-1 pl-1 w-1/4">
                <label class="hidden block text-sm text-gray-600" for="state">State</label>
                <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="state"  name="state" type="text" required="" placeholder="State" aria-label="state">
            </div>
            <div class="inline-block mt-2 mx-1 pl-1 w-1/4">
                <label class="hidden block text-sm text-gray-600" for="zip">Zip</label>
                <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="zip"  name="zip" type="text" required="" placeholder="Zip" aria-label="zip">
            </div>
            <div class="inline-block mt-4 w-1/2 text-right">
                $
            </div>
            <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
                <label class="hidden block text-sm text-gray-600" for="amount">Amount</label>
                <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="amount"  name="amount" type="text" required="" placeholder="Amount" aria-label="amount">
            </div>
        @else
            <div class="inline-block mt-4 w-1/2 pr-1">
              <label class="block text-sm text-gray-600" for="invoice">Invoice</label>
              #{{ $invoice->id ?? '' }}
              <input type="hidden" name="invoice" value="{{ $invoice->id }}" id="invoice" />
            </div>
            <div class="inline-block mt-4 -mx-1 pl-1 w-1/2">
              <label class="block text-sm text-gray-600" for="amount">Amount</label>
              {{ number_format($invoice->balance,2) ?? ''}}
              <input type="hidden" name="amount" value="{{ number_format($invoice->balance,2) ?? ''}}" id="amount" />
            </div>
        @endif
        <input type="hidden" name="dataValue" id="dataValue" />
        <input type="hidden" name="dataDescriptor" id="dataDescriptor" />
        <input type="hidden" name="updated" id="updated" value={{$cardData['cardNumber']??1}}>
        <div class="mt-4">
          <button  onclick="checkIfUpdated()" class="btn-std btn-std-dk-green" type="button">Submit Payment</button>
        </div>
      </form>
    </div>
</div>
<script type="text/javascript" src="https://js.authorize.net/v1/Accept.js" charset="utf-8"></script>
<script type="text/javascript">
    function checkIfUpdated() {
        var cardNumber = document.getElementById("number").value;
        var expire = document.getElementById("expire").value;
        if (cardNumber.match(/X{4}\d{4}/) && expire.match(/X{4}/)) {
            document.getElementById("paymentForm").submit();
        }
        if (!cardNumber.match(/X{4}\d{4}/) || !expire.match(/X{4}/)) {
            document.getElementById("updated").value = 1;
            sendPaymentDataToAnet();
        }
    }
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
        console.log(response);
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
        console.log(opaqueData);
        document.getElementById("dataDescriptor").value = opaqueData.dataDescriptor;
        document.getElementById("dataValue").value = opaqueData.dataValue;
        document.getElementById("number").value = "";
        document.getElementById("expire").value = "";
        document.getElementById("cvc").value = "";
        document.getElementById("paymentForm").submit();
    }

    function validateCard() {
        var expire = document.getElementById("expire").value;
        var cvc = document.getElementById("cvc").value;
        var number = document.getElementById("number").value;
        if (!expire.includes('/')) {
            alert('Your Expiration Date Does Not Include A \'/\'');
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
            alert('You Input An Invalid Month');
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
