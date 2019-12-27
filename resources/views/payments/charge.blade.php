@extends('layouts.app')
@section('title', 'Charge Card')
@section('content')


<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h3 class="font-bold pl-2"><a href="{{ route('credits') }}">Payments</a> / New Payment</h3>
</div>
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-5/6 p-3">
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-400 border-b-2 border-gray-500 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600">Payment Details</h5>
            </div>
            <div class="p-5" id="app">
                <form id="paymentForm"
                    method="POST"
                    action="/charge/card" >
                    <input type="text" name="cardNumber" id="cardNumber" placeholder="cardNumber"/> <br><br>
                    <input type="text" name="expMonth" id="expMonth" placeholder="expMonth"/> <br><br>
                    <input type="text" name="expYear" id="expYear" placeholder="expYear"/> <br><br>
                    <input type="text" name="cardCode" id="cardCode" placeholder="cardCode"/> <br><br>
                    <input type="text" name="nameOnAccount" id="nameOnAccount" placeholder="nameOnAccount"/> <br><br>
                    <input type="text" name="accountType" id="accountType" placeholder="accountType"/> <br><br>
                    <input type="hidden" name="dataValue" id="dataValue" />
                    <input type="hidden" name="dataDescriptor" id="dataDescriptor" />
                    <button type="button" onclick="sendPaymentDataToAnet()">Pay</button>
                </form>
            </div>
        </div>
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
