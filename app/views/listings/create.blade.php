@extends('layouts.default')

@section('content')
<h1>Add new listing</h1>

<p><a href="{{ route('listings') }}">Back to listings overview</a></p>

{{ Form::open(array('route' => 'listings.store', 'method' => 'post', 'class' => 'smart-form')) }}

{{ Form::label('name', 'Name', array('class' => 'label')) }}
{{ Form::text('name', Input::old('name'), $attributes = array('class' => 'inline', 'id' => 'name', 'placeholder' => 'a good name')) }}
{{ $errors->first('name', '<div class="note note-error">:message</div>') }}

{{ Form::label('beds', 'Beds', array('class' => 'label')) }}
{{ Form::text('beds', Input::old('beds'), $attributes = array('class' => 'inline', 'id' => 'beds', 'placeholder' => 'x')) }}
{{ $errors->first('beds', '<div class="note note-error">:message</div>') }}


{{ Form::label('guests', 'Guests', array('class' => 'label')) }}
{{ Form::text('guests', Input::old('guests'), $attributes = array('class' => 'inline', 'id' => 'guests', 'placeholder' => 'x')) }}
{{ $errors->first('guests', '<div class="note note-error">:message</div>') }}


{{ Form::label('address', 'Address', array('class' => 'label')) }}
{{ Form::textarea('address', Input::old('address'), $attributes = array('class' => 'inline', 'id' => 'address', 'placeholder' => 'Street')) }}
{{ $errors->first('address', '<div class="note note-error">:message</div>') }}

{{ Form::submit('Save new listing', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop