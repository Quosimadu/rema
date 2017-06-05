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
                        <p><a class="" href="{!! route('messages') !!}"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                 Back to messages overview</a></p>
                        <p>Message: {!! $message->content !!}</p>
                        <p>{!! $message->sender !!} <i class="fa fa-arrow-right" aria-hidden="true"></i> {!! $message->receiver !!}</p>
                        <p><i>Sent: {!! $message->created_at !!}</i></p>
                        @if ($message->is_incoming == 0)
                            <p><i>Has been sent: {!! $message->is_sent !!}</i></p>
                            <p><i>Reception confirmed: {!! $message->received_at !!}</i></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop