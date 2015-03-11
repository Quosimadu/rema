@extends('layouts.default')

@section('content')
    <h1>Edit booking of {{ $booking->guest_name }}</h1>

    <p><a href="{{ route('bookings') }}">Back to bookings overview</a></p>

    {{ Form::open(array('route' => 'bookings.update', 'method' => 'PUT', 'class' => 'smart-form')) }}


    {{ Form::hidden('platform_id', $booking->platform_id) }}

    {{ Form::label('booking_status_id', 'Status', array('class' => 'label')) }}
    {{ Form::select('booking_status_id', $bookingStatuses, $booking->booking_status_id) }}
    {{ $errors->first('booking_status_id', '<div class="note note-error">:message</div>') }}

    {{ Form::label('listing_id', 'Listing', array('class' => 'label')) }}
    {{ Form::select('listing_id', $listings, $booking->listing_id) }}
    {{ $errors->first('listing_id', '<div class="note note-error">:message</div>') }}

    {{ Form::label('guest_name', 'Guest', array('class' => 'label')) }}
    {{ Form::text('guest_name', $booking->guest_name, $attributes = array('class' => 'inline', 'id' => 'guest_name', 'placeholder' => 'John Doe')) }}
    {{ $errors->first('guest_name', '<div class="note note-error">:message</div>') }}

    {{ Form::label('inquiry_date', 'First inquiry date', array('class' => 'label')) }}
    {{ Form::text('inquiry_date', $booking->inquiry_date, $attributes = array('class' => 'inline', 'id' => 'inquiry_date', 'placeholder' => '2014-12-01')) }}
    {{ $errors->first('inquiry_date', '<div class="note note-error">:message</div>') }}

    {{ Form::label('arrival_date', 'Arrival date', array('class' => 'label')) }}
    {{ Form::text('arrival_date', $booking->arrival_date, $attributes = array('class' => 'inline', 'id' => 'arrival_date', 'placeholder' => '2014-12-01')) }}
    {{ $errors->first('arrival_date', '<div class="note note-error">:message</div>') }}

    {{ Form::label('arrival_time', 'Arrival time', array('class' => 'label')) }}
    {{ Form::text('arrival_time', $booking->arrival_time, $attributes = array('class' => 'inline', 'id' => 'arrival_time', 'placeholder' => '18:00')) }}
    {{ $errors->first('arrival_time', '<div class="note note-error">:message</div>') }}

    {{ Form::label('departure_date', 'Departure date', array('class' => 'label')) }}
    {{ Form::text('departure_date', $booking->departure_date, $attributes = array('class' => 'inline', 'id' => 'departure_date', 'placeholder' => '2014-12-01')) }}
    {{ $errors->first('departure_date', '<div class="note note-error">:message</div>') }}

    {{ Form::label('departure_time', 'Departure time', array('class' => 'label')) }}
    {{ Form::text('departure_time', $booking->departure_time, $attributes = array('class' => 'inline', 'id' => 'departure_time', 'placeholder' => '18:00')) }}
    {{ $errors->first('departure_time', '<div class="note note-error">:message</div>') }}

    {{ Form::label('guest_country', 'Country', array('class' => 'label')) }}
    {{ Form::text('guest_country', $booking->guest_country, $attributes = array('class' => 'inline', 'id' => 'guest_country', 'placeholder' => 'DE')) }}
    {{ $errors->first('guest_country', '<div class="note note-error">:message</div>') }}

    {{ Form::label('guest_email', 'Email', array('class' => 'label')) }}
    {{ Form::text('guest_email', $booking->guest_email, $attributes = array('class' => 'inline', 'id' => 'guest_email', 'placeholder' => '')) }}
    {{ $errors->first('guest_email', '<div class="note note-error">:message</div>') }}


    {{ Form::label('people', 'Guests', array('class' => 'label')) }}
    {{ Form::number('people', $booking->people, $attributes = array('class' => 'inline', 'id' => 'people', 'placeholder' => '2')) }}
    {{ $errors->first('people', '<div class="note note-error">:message</div>') }}


    {{ Form::label('comment', 'Comment', array('class' => 'label')) }}
    {{ Form::textarea('comment', $booking->comment, $attributes = array('class' => 'inline', 'id' => 'comment', 'placeholder' => 'Comment')) }}
    {{ $errors->first('comment', '<div class="note note-error">:message</div>') }}

    {{ Form::label('airbnb_conversation_id', 'AirBnB Conversation ID', array('class' => 'label')) }}
    {{ Form::text('airbnb_conversation_id', $booking->airbnb_conversation_id, $attributes = array('class' => 'inline', 'id' => 'airbnb_conversation_id', 'placeholder' => '1id8x912')) }}
    {{ $errors->first('airbnb_conversation_id', '<div class="note note-error">:message</div>') }}

    {{ Form::submit('Save new booking', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

<p><a href="{{ route('bookingDelete', $booking->id) }}">Delete booking</a></p>

@stop