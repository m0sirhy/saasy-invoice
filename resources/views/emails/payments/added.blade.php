@component('mail::layout')

@slot('header')
	@component('mail::header', ['url' => $url])
		{{ $company }}
	@endcomponent
@endslot

<b>{{$client->name}}</b>

A payment for an invoice due to {{ $company }} has been processed in the amount of ${{ number_format($amount, 2) }}.  Click the link below to view invoice #{{ $invoice->id }}.

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
