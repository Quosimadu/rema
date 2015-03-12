@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Listings</h1>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Guests</th>
                                <th>Beds</th>
                                <th>Address</th>
                            </tr>
                            <thead>
                            @foreach($listings as $listing)
                                <tr>
                                    <td><a href="{!! route('listingShow', $listing->id) !!}">{!! $listing->name !!}</a>
                                    </td>
                                    <td>{!! $listing->guests !!}</td>
                                    <td>{!! $listing->beds !!}</td>
                                    <td>{!! $listing->address !!}</td>
                                    <td><a href="{!! route('listingEdit', $listing->id) !!}">edit</a></td>
                                </tr>

                            @endforeach
                        </table>
                        <p><a class="btn btn-primary" href="{!! route('listingCreate') !!}">Add new listing</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop