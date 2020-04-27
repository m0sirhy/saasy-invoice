@component('mail::layout')

@slot('header')
	@component('mail::header', ['url' => $url])
		{{ $company }}
	@endcomponent
@endslot

A payment for has been processed for {{ $company }} in the amount of ${{ number_format($payment->amount, 2) }}.<br><br>In the event that this payment has been processed in error, please contact {{ $email }}.

Thanks,<br>
{{ $company }}

	@slot('footer')
		@component('mail::footer')
			© {{ date('Y') }} {{ $company }}. @lang('All rights reserved.')
		@endcomponent
	@endslot
@endcomponent
