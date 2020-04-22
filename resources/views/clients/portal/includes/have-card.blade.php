<div class="bg-blue-100 border-b-4 border-blue-600 rounded-lg shadow-lg p-5 items-center">
  <h5 class="font-bold uppercase text-gray-600 text-center">Card on File</h5>
  <div class="py-2">
      <div class="w-full rounded overflow-hidden shadow-lg bg-white">
          <div class="px-6 py-4">
            {!! Form::model($invoice, ['route' => ['client.invoice.payment', 'invoice' => $invoice->public_id], 'id' => 'useCard']) !!}
              <div class="inline-block mt-4 w-1/2 pr-1">
                <label class="block text-sm text-gray-600" for="card">Card on File</label>
                {{ $cardData['cardType'] }} ending in {{ substr($cardData['cardNumber'], -4) }}
              </div>
              <div class="inline-block mt-4 w-1/2 pr-1">
                <label class="block text-sm text-gray-600" for="invoice">Invoice</label>
                #{{ $invoice->id }}
              </div>
              <div class="inline-block mt-4 -mx-1 pl-1 w-1/2">
                <label class="block text-sm text-gray-600" for="amount">Amount</label>
                ${{ number_format($invoice->balance,2) }}
              </div>
              <input type="hidden" name="invoice" value="{{ $invoice->id }}" id="invoice" />
              <input type="hidden" name="amount" value="{{ $invoice->balance }}" id="amount" />
              <input type="hidden" name="dataValue" id="dataValue" />
              <input type="hidden" name="dataDescriptor" id="dataDescriptor" />
              <input type="hidden" name="updated" id="updated" />
              <div class="mt-4">
                <button  onclick="checkIfUpdated()" class="px-4 py-1 text-white font-light tracking-wider bg-green-900 rounded" type="button">Submit Payment</button>
              </div>
            </form>
          </div>
      </div>
  </div>
</div>
<br/>