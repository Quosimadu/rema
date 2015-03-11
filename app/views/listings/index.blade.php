@extends('layouts.default')

@section('content')
<h1>Listings</h1>
<table>
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
	                                    <td><a href="{{ route('listingShow', $listing->id) }}">{{ $listing->name }}</a></td>
										<td>{{ $listing->guests }}</td>
										<td>{{ $listing->beds }}</td>
										<td>{{ $listing->address }}</td>
										<td><a href="{{ route('listingEdit', $listing->id) }}">edit</a></td>
	</tr>

@endforeach
</table>
<p><a href="{{ route('listingCreate') }}">Add new listing</a></p>
@stop