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
                        <p><a class="btn btn-link" href="{!! route('listings') !!}"><i class="fa fa-arrow-left"
                                                                                       aria-hidden="true"></i>
                                Back to listings overview</a></p>

                        <p>Guests: {!! $listing->guests !!}</p>

                        <p>Beds: {!! $listing->beds !!}</p>

                        <p>Address: <a href="https://www.google.cz/maps/place/{!! urlencode($listing->address) !!}" title="Show on Google Maps">{!! $listing->address !!}</a></p>

                        <p>Check-in: {!! $listing->check_in_time !!}</p>

                        <p>Check-out: {!! $listing->check_out_time !!}</p>

                        @if (!empty($listing->airbnb_listing_id))
                            <p><a href="https://www.airbnb.com/rooms/{!! $listing->airbnb_listing_id !!}">AirBnB preview</a>
                                <a href="https://www.airbnb.com/manage-listing/{!! $listing->airbnb_listing_id !!}/calendar">AirBnB calendar</a>
                            </p>
                        @endif
                        @if (!$listing->is_active)
                            <p>Listing is inactive
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop