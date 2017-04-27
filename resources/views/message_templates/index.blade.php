@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Message Templates</h1>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Content</th>
                                <th>Comment</th>
                            </tr>
                            <thead>
                            @foreach($message_templates as $message_template)
                                <tr>
                                    <td><a href="{!! route('message_templates.create', $message_template->id) !!}">{!! $message_template->name !!}</a></td>
                                    <td>{!! $message_template->content !!}</td>
                                    <td>{!! $message_template->comment !!}</td></tr>

                            @endforeach
                        </table>
                        <p><a class="btn btn-primary" href="{!! route('message_templates.create') !!}">Add new message_template</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop