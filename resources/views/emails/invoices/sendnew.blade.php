@component('mail::layout')

@slot('header')
	@component('mail::header', ['url' => $url])
		{{$company}}
	@endcomponent
@endslot

<b>{{$client->name}}</b>

You have a new invoice from {{ $company }} for ${{$invoice->balance}}.  Click the link below to view invoice #{{$invoice->id}}.

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
