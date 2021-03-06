<div class="bg-blue-100 border-b-4 border-blue-600 rounded-lg shadow-lg p-5 items-center">
  <h5 class="font-bold uppercase text-gray-600 text-center">New Payment Method</h5>
  <div class="py-2">
      <div class="w-full rounded overflow-hidden shadow-lg bg-white">
          <div class="px-6 py-4">
            {!! Form::model($invoice, ['route' => ['client.invoice.payment', 'invoice' => $invoice->public_id], 'id' => 'paymentForm']) !!}
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
              <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
                <label class="hidden block text-sm text-gray-600" for="cvc">CVC</label>
                <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="zip"  name="zip" type="text" required="" placeholder="Zip Code" aria-label="zip">
              </div>
              <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
              </div>
              <div class="inline-block mt-4 w-1/2 pr-1">
                <label class="block text-sm text-gray-600" for="invoice">Invoice</label>
                #{{ $invoice->id }}
              </div>
              <div class="inline-block mt-4 -mx-1 pl-1 w-1/2">
                <label class="block text-sm text-gray-600" for="amount">Amount</label>
                ${{ number_format($invoice->balance,2) }}
              </div>
              <input type="hidden" name="updated" value="{{ $cardData ? 1 : 0}}" />
              <input type="hidden" name="invoice" value="{{ $invoice->id }}" id="invoice" />
              <input type="hidden" name="amount" value="{{ $invoice->balance }}" id="amount" />
              <input type="hidden" name="dataValue" id="dataValue" />
              <input type="hidden" name="dataDescriptor" id="dataDescriptor" />
              <div class="mt-4">
                <button  onclick="sendPaymentDataToAnet()" class="btn-std btn-std-dk-green" type="button">Submit Payment</button>
              </div>
              <div class="inline-block mt-2 mx-1 pl-1 w-full text-sm">
                *This payment information will be used for all future billings for your account.
              </div>
            </form>
          </div>
      </div>
  </div>
</div>
