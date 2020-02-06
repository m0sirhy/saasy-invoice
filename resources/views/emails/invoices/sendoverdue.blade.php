@component('mail::message')
# {{ CMP_NAME }}

You have an overdue invoice from {{ CMP_NAME }}.

@component('mail::button', ['url' => route('client.login', $client->uuid)])
View Invoices
@endcomponent
Thanks,<br>
{{ CMP_NAME }}
@endcomponent
