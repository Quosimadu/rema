@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Listings</h1>
                    </div>
                    <div class="panel-body">
                        <p class=""><a class="" href="{!! route('listingCreate') !!}" title="New listing"><i
                                        class="fa fa-plus-circle fa-2x" aria-hidden="true"></i></a></p>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Guests</th>
                                <th>Beds</th>
                                <th>Address</th>
                                <th>AirBnB</th>
                                <th>Fnc</th>
                            </tr>
                            <thead>
                            @foreach($listings as $listing)
                                <tr>
                                    <td><a href="{!! route('listingShow', $listing->id) !!}">{!! $listing->name !!}</a>
                                    </td>
                                    <td>{!! $listing->guests !!}</td>
                                    <td>{!! $listing->beds !!}</td>
                                    <td>{!! $listing->address !!}</td>
                                    <td>
                                        @if (!empty($listing->airbnb_listing_id))
                                        <a href="https://www.airbnb.com/manage-listing/{!! $listing->airbnb_listing_id !!}/calendar" title="AirBnB calendar">A-C</a>
                                        @endif
                                    </td>
                                    <td><a href="{!! route('listingEdit', $listing->id) !!}">edit</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop