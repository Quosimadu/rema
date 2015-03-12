@extends('app')

@section('content')
<h1>{!! $listing->name !!}</h1>
<p><a href="{!! route('listings') !!}">Back to listings overview</a></p>
<p>Guests: {!! $listing->guests !!}</p>
<p>Beds: {!! $listing->beds !!}</p>
<p>Address: {!! $listing->address !!}</p>

@stop