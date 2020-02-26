                <form id="paymentForm"
                    method="POST"
                    action="/charge/card" >
                    @csrf
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