SMS message received

@component('mail::panel')
At: {{ $message->created_at }}
From: {{ $message->sender }}
To: {{ $message->receiver }}
Message: {{ $message->content }}
@endcomponent

Sent by {{ config('app.name') }}