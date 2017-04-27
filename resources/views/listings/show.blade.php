@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>{!! $listing->name !!}</h1>
                    </div>
                    <div class="panel-body">
                        <p><a class="btn btn-link" href="{!! route('listings') !!}">Back to listings overview</a></p>

                        <p>Guests: {!! $listing->guests !!}</p>

                        <p>Beds: {!! $listing->beds !!}</p>

                        <p>Address: {!! $listing->address !!}</p>

                        <p>Check-in: {!! $listing->checkin_time !!}</p>

                        <p>Check-out: {!! $listing->checkout_time !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop