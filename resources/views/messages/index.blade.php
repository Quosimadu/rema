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
                        <p><a class="btn btn-primary" href="{!! route('messages.compose') !!}">Compose message</a></p>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Sender</th>
                                <th>Receiver</th>
                                <th>Content</th>
                            </tr>
                            <thead>
                            @foreach($messages as $message)
                                <tr>
                                    <td>{!! $message->created_at !!}</td>
                                    <td>{!! $message->sender !!}</td>
                                    <td>{!! $message->receiver !!}</td>
                                    <td><a href="{!! route('messages.show', $message->id) !!}">{!! $message->content !!}</a></td>
                                </tr>

                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop