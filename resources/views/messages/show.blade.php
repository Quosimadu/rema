@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Message details</h1>
                    </div>
                    <div class="panel-body">
                        <p><a class="btn btn-link" href="{!! route('messages') !!}">Back to messages overview</a></p>
                        <p>Sender: {!! $message->sender !!}</p>
                        <p>Receiver: {!! $message->receiver !!}</p>
                        <p><i>Sent: {!! $message->created_at !!}</i></p>
                        <p>Message: {!! $message->content !!}</p>
                        @if ($message->is_incoming == 0)
                            <p><i>Has been sent: {!! $message->is_sent !!}</i></p>
                            <p><i>Received: {!! $message->received_at !!}</i></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop