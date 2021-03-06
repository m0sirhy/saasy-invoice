@component('mail::layout')

@slot('header')
	@component('mail::header', ['url' => $url])
		{{$company}}
	@endcomponent
@endslot

<b>{{$client->name}}</b>


You have an overdue invoice from {{ $company }} with a remaining balance of <b>${{$invoice->balance}}</b>.  Click the link below to view invoice <b>#{{$invoice->id}}</b>.

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