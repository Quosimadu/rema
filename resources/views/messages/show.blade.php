@extends('layouts.app')

@section('title')
    Message :: Details :: @parent
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Message details</h1>
                    </div>
                    <div class="panel-body">
                        <p><a class="" href="{!! route('messages') !!}"><i class="fa fa-arrow-left"
                                                                           aria-hidden="true"></i>
                                Back to messages overview</a></p>
                        <div class="well"><strong>{!! $message->content !!}</strong><br/><br/>

                            <i>{!! $message->sender !!} <i class="fa fa-angle-double-right"
                                                           aria-hidden="true"></i> {!! $message->receiver !!}</i><br/>
                            <i>({!! $message->created_at !!})</i>
                        </div>

                        @if ($message->is_incoming == 0)
                            <p><i>Has been sent: {!! $message->is_sent !!}</i></p>
                            <p><i>Reception confirmed: {!! $message->received_at !!}</i></p>
                            @if ($message->createdBy)
                                <p><i>Sent by: {!! $message->createdBy->name !!}</i></p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop