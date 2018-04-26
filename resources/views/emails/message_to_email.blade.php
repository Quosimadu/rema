SMS message received

@component('mail::panel')
At: {{ $textMessage->created_at }}
From: {{ $textMessage->sender }}
To: {{ $textMessage->receiver }}
Message: {{ $textMessage->content }}
@endcomponent

Sent by {{ config('app.name') }}