@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Messages</h1>
                    </div>
                    <div class="panel-body">
                        <p><a class="" href="{!! route('messages.compose') !!}" title="Compose message"><i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i></a></p>
                        <table class="table">
                            @foreach($messages as $message)
                                <tr>
                                    <td><a href="{!! route('messages.show', $message->id) !!}">{!! \Illuminate\Support\Str::words($message->content, 4, "...") !!}</a></td>
                                    <td>{!! $message->sender !!} <i class="fa fa-angle-double-right" aria-hidden="true"></i> {!! $message->receiver !!}</td>
                                    <td>{!! $message->created_at !!}</td>
                                </tr>

                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop