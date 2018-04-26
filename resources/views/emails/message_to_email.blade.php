<h2>SMS message received</h2>
@component('mail::panel')
    {{ $textMessage->content }}
@endcomponent
<p>At: {{ $textMessage->created_at }}<br/>
    From: {{ $textMessage->sender }}<br/>
    To: {{ $textMessage->receiver }}</p>

<p><i>Sent by {{ config('app.name') }}</i></p>