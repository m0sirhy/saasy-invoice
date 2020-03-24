@component('mail::message')
# {{CMP_NAME}}

You have a new invoice from {{CMP_NAME}}.  Click the link below to view the invoice.

@component('mail::button', ['url' => route('client.login', $client->uuid)])
View Invoices
@endcomponent
Thanks,<br>
{{ CMP_NAME }}
@endcomponent
