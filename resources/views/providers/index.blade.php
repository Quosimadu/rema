@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Providers</h1>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>E-Mail</th>
                            </tr>
                            <thead>
                            @foreach($providers as $provider)
                                <tr>
                                    <td><a href="{!! route('providerShow', $provider->id) !!}">{!! $provider->last_name !!}, {!! $provider->first_name !!}</a></td>
                                    <td>{!! $provider->mobile !!}</td>
                                    <td>{!! $provider->email !!}</td>
                                    <td><a href="{!! route('providerEdit', $provider->id) !!}">edit</a></td>
                                </tr>

                            @endforeach
                        </table>
                        <p><a class="btn btn-primary" href="{!! route('providerCreate') !!}">Add new provider</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop