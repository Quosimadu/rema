<h2>SMS message received</h2>

@component('mail::panel')
<p>At: {{ $textMessage->created_at }}<br/>
From: {{ $textMessage->sender }}<br/>
To: {{ $textMessage->receiver }}<br/>
Message: {{ $textMessage->content }}</p>
@endcomponent

<p><i>Sent by {{ config('app.name') }}</i></p>