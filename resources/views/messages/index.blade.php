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
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Receiver</th>
                                <th>Content</th>
                            </tr>
                            <thead>
                            @foreach($messages as $message)
                                <tr>
                                    <td>{!! $message->created_at !!}</td>
                                    <td>{!! $message->receiver !!}</td>
                                    <td><a href="{!! route('messages.show', $message->id) !!}">{!! $message->content !!}</a></td>
                                </tr>

                            @endforeach
                        </table>
                        <p><a class="btn btn-primary" href="{!! route('messages.compose') !!}">Add new message</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop