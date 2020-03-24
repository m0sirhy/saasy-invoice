@component('mail::message')
# SaasyInvoice

Registration completed!

<a href="{{ route('dashboard') }}">Click here</a> to login to your account.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
