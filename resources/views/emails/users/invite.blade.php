@component('mail::message')
# SaasyInvoice

You've been invite to use SaasyInvoice. Click the link below to active your account.

<a href="{{ route('user.activate', $token) }}">Click here</a> to activate your account.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
