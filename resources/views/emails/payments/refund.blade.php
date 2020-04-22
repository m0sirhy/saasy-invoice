@component('mail::layout')

@slot('header')
	@component('mail::header', ['url' => $url])
		{{ $company }}
	@endcomponent
@endslot

<b>{{$client->name}}</b>

A payment made for ${{ number_format($payment->amount, 2) }} has been refunded by {{ $company }}.  Click the link below to view invoice #{{ $invoice->id }}.

@component('mail::button', ['url' => route('client.login', $client->uuid)])
View Invoices
@endcomponent
Thanks,<br>
{{ $company }}

	@slot('footer')
		@component('mail::footer')
			© {{ date('Y') }} {{ $company }}. @lang('All rights reserved.')
		@endcomponent
	@endslot
@endcomponent
