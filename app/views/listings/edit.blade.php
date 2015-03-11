@extends('layouts.default')

@section('content')
<h1>Edit {{ $listing->name }}</h1>

<p><a href="{{ route('listings') }}">Back to listings overview</a></p>

{{ Form::open(array('route' => array('listings.update', $listing->id), 'method' => 'PUT', 'class' => 'smart-form')) }}

{{ Form::label('name', 'Name', array('class' => 'label')) }}
{{ Form::text('name', $listing->name, $attributes = array('class' => 'inline', 'id' => 'order_id', 'placeholder' => 'a good name')) }}

{{ Form::label('beds', 'Beds', array('class' => 'label')) }}
{{ Form::number('beds', $listing->beds, $attributes = array('class' => 'inline', 'id' => 'order_id', 'placeholder' => 'x')) }}

{{ Form::label('guests', 'Guests', array('class' => 'label')) }}
{{ Form::number('guests', $listing->guests, $attributes = array('class' => 'inline', 'id' => 'order_id', 'placeholder' => 'x')) }}

{{ Form::label('address', 'Address', array('class' => 'label')) }}
{{ Form::textarea('address', $listing->address, $attributes = array('class' => 'inline', 'id' => 'address', 'placeholder' => 'Street')) }}
{{ $errors->first('address', '<div class="note note-error">:message</div>') }}

{{ Form::submit('Save new listing', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop