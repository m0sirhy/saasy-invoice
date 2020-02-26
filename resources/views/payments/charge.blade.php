@extends('layouts.app')
@section('title', 'Charge Card')
@section('content')


<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('credits') }}">Payments</a> / New Payment</h3>
</div>
<div class="flex flex-wrap">
    <div class="leading-loose">
      <form class="max-w-xl m-4 p-10 bg-white rounded shadow-xl">
        <p class="text-gray-800 font-medium">Customer information</p>
        <div class="">
          <label class="block text-sm text-gray-00" for="cus_name">Name</label>
          <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="cus_name" name="cus_name" type="text" required value="{{ $invoice->Client->name }}" aria-label="Name">
        </div>
        <div class="mt-2">
          <label class="block text-sm text-gray-600" for="cus_email">Email</label>
          <input class="w-full px-5  py-4 text-gray-700 bg-gray-200 rounded" id="cus_email" name="cus_email" type="text" required="" placeholder="Your Email" aria-label="Email">
        </div>
        <div class="mt-2">
          <label class=" block text-sm text-gray-600" for="cus_email">Address</label>
          <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="cus_email" name="cus_email" type="text" required="" placeholder="Street" aria-label="Email">
        </div>
        <div class="mt-2">
          <label class="hidden text-sm block text-gray-600" for="cus_email">City</label>
          <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="cus_email" name="cus_email" type="text" required="" placeholder="City" aria-label="Email">
        </div>
        <div class="inline-block mt-2 w-1/2 pr-1">
          <label class="hidden block text-sm text-gray-600" for="cus_email">Country</label>
          <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="cus_email" name="cus_email" type="text" required="" placeholder="Country" aria-label="Email">
        </div>
        <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
          <label class="hidden block text-sm text-gray-600" for="cus_email">Zip</label>
          <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="cus_email"  name="cus_email" type="text" required="" placeholder="Zip" aria-label="Email">
        </div>
        <p class="mt-4 text-gray-800 font-medium">Payment information</p>
        <div class="">
          <label class="block text-sm text-gray-600" for="cus_name">Card</label>
          <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="cus_name" name="cus_name" type="text" required="" placeholder="Card Number MM/YY CVC" aria-label="Name">
        </div>
        <div class="mt-4">
          <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" type="submit">$3.00</button>
        </div>
      </form>
    </div>
</div>

<script type="text/javascript">
    function sendPaymentDataToAnet() {
        var authData = {};
            authData.clientKey = "8dnc35vzqDQ4nwfWhr96N7JhU4DQLFYtmu26Zf7BEsXCEX4sesADX623w83f2jm4";
            authData.apiLoginID = "6Ux8Sw4m";

        var cardData = {};
            cardData.cardNumber = document.getElementById("cardNumber").value;
            cardData.month = document.getElementById("expMonth").value;
            cardData.year = document.getElementById("expYear").value;
            cardData.cardCode = document.getElementById("cardCode").value;

        // If using banking information instead of card information,
        // build a bankData object instead of a cardData object.
        //
        // var bankData = {};
        //     bankData.accountNumber = document.getElementById('accountNumber').value;
        //     bankData.routingNumber = document.getElementById('routingNumber').value;
        //     bankData.nameOnAccount = document.getElementById('nameOnAccount').value;
        //     bankData.accountType = document.getElementById('accountType').value;

        var secureData = {};
            secureData.authData = authData;
            secureData.cardData = cardData;
            // If using banking information instead of card information,
            // send the bankData object instead of the cardData object.
            //
            // secureData.bankData = bankData;
        console.log(secureData);
        Accept.dispatchData(secureData, responseHandler);
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
        document.getElementById("dataDescriptor").value = opaqueData.dataDescriptor;
        document.getElementById("dataValue").value = opaqueData.dataValue;

        // If using your own form to collect the sensitive data from the customer,
        // blank out the fields before submitting them to your server.
        document.getElementById("cardNumber").value = "";
        document.getElementById("expMonth").value = "";
        document.getElementById("expYear").value = "";
        document.getElementById("cardCode").value = "";
        document.getElementById("nameOnAccount").value = "";
        document.getElementById("accountType").value = "";

        document.getElementById("paymentForm").submit();
    }
</script>
@endsection
