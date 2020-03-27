<div>
    <div class="mx-auto">
      <div class="bg-white shadow-md rounded my-6">
        <div class="my-2 flex sm:flex-row flex-col">
                <div class="block relative">
                    <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                            <path
                                d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                            </path>
                        </svg>
                    </span>
                    <input placeholder="Search"
                        class="appearance-none rounded-r rounded-l sm:rounded-lg-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" 
                        wire:model="search" />
                </div>
                <div class="w-1/12">
                    <a href={{route('payments.download.excel', ['sortField' => $sortField, 'sortAsc' => $sortAsc ? 'asc' : 'desc', 'search' => $search])}}><button class="ml-2 py-2 rounded-l rounded-r border-gray-400 bg-gray-200 border sm:rounded-lg-none block w-full text-sm text-gray-700 focus: bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none">Excel</button></a>
                </div>
            </div>
            <table class="text-left w-full border-collapse">
                <thead>
                    <tr>
                        <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light>">
                            <a wire:click.prevent="sortBy('id')" role="button" href="#">
                            ID
                            @include('includes._sort-icon', ['field' => 'id'])
                            </a>
                        </th>
                        <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light>">
                            <a wire:click.prevent="sortBy('client.name')" role="button" href="#">
                            Name
                            @include('includes._sort-icon', ['field' => 'name'])
                            </a>
                        </th>
                        <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">
                            <a wire:click.prevent="sortBy('invoice_id')" role="button" href="#">
                            Invoice #
                            @include('includes._sort-icon', ['field' => 'invoice_id'])
                            </a>
                        </th>
                        <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">
                            <a wire:click.prevent="sortBy('amount')" role="button" href="#">
                            Amount
                            @include('includes._sort-icon', ['field' => 'amount'])
                            </a>
                        </th>
                        <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">
                            <a wire:click.prevent="sortBy('amount')" role="button" href="#">
                            Date
                            @include('includes._sort-icon', ['field' => 'payment_at'])
                            </a>
                        </th>
                        <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">
                            <a wire:click.prevent="sortBy('payment_type')" role="button" href="#">
                            Type
                            @include('includes._sort-icon', ['field' => 'payment_type'])
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr class="hover:bg-grey-lighter">
                            <td class="py-4 px-6 border-b border-grey-light">
                                <a class="link" href="{{ route('payments.edit', ['payment' => $payment->id]) }}">{{ $payment->id }}</a>
                            </td>
                            <td class="py-4 px-6 border-b border-grey-light"><a class="link" href=@if($payment->client_id != 0){{ route('clients.show', ['client' => $payment->client_id]) }}@endif>{{ $payment->client->name ?? 'Credit Card' }}</a></td>
                            <td class="py-4 px-6 border-b border-grey-light">
                                <a class="link" href="{{ route('invoices.edit', ['invoice' => $payment->invoice_id]) }}">{{ $payment->invoice_id }}</a>
                            </td>
                            <td class="py-4 px-6 border-b border-grey-light">${{ number_format($payment->amount, 2) }}</td>
                            <td class="py-4 px-6 border-b border-grey-light">{{ $payment->payment_at->format('m/d/y') }}</td>
                            <td class="py-4 px-6 border-b border-grey-light">{{ $payment->payment_type ?? 'Unknown' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $payments->links('includes.pagination') }}
            <div class="text-center py-2 px-6">
                Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} out of {{ $payments->total() }} results
            </div>
        </div>
    </div>
</div>
