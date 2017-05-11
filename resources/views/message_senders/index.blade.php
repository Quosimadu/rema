@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Message Senders</h1>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Number</th>
                                <th>Provider</th>
                            </tr>
                            <thead>
                            @foreach($messageSenders as $messageSender)
                                <tr>
                                    <td><a href="{!! route('message_senders.edit', $messageSender->id) !!}">{!! $messageSender->name !!}</a></td>
                                    <td>{!! $messageSender->number !!}</td>
                                    <td>{!! $messageSender->provider !!}</td>
                                </tr>

                            @endforeach
                        </table>
                        <p><a class="btn btn-primary" href="{!! route('message_senders.create') !!}">Add new sender</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop