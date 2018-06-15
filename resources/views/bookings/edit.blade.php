@extends('layouts.app')

@section('title')
    Bookings :: Edit :: @parent
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Edit booking of {!! $booking->guest_name !!}</h1>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(array('route' => array('bookingUpdate', $booking->id), 'method' => 'PUT', 'class' => 'form-horizontal')) !!}

                        {!! Form::hidden('platform_id', $booking->platform_id) !!}


                        <div class="form-group">
                            {!! Form::label('listing_id', 'Listing', array('class' => 'col-md-1 control-label')) !!}

                            <div class="col-md-3">
                                {!! Form::select('listing_id', $listings, $booking->listing_id, array('class' =>
                                'form-control')) !!}
                                {!! $errors->first('listing_id', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                            {!! Form::label('people', 'Guests', array('class' => 'col-md-1 control-label')) !!}

                            <div class="col-md-1">
                                {!! Form::number('people', $booking->people, $attributes = array('class' => 'form-control',
                                'id' => 'people', 'placeholder' => '2')) !!}
                                {!! $errors->first('people', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>

                            {!! Form::label('guest_name', 'Name', array('class' => 'col-md-1 control-label')) !!}

                            <div class="col-md-4">
                                {!! Form::text('guest_name', $booking->guest_name, $attributes = array('class' =>
                                'form-control', 'id' => 'guest_name', 'placeholder' => 'John Doe')) !!}
                                {!! $errors->first('guest_name', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('guest_phone', 'Mobile', array('class' => 'col-md-1 control-label')) !!}

                            <div class="col-md-4 col-rg-offset-1">
                                {!! Form::text('guest_phone', $booking->guest_phone, $attributes = array('class' =>
                                'form-control', 'id' => 'guest_phone', 'placeholder' => '')) !!}
                                {!! $errors->first('guest_phone', '
                                <div class="note note-error">:message</div>
                                ') !!}</div>

                            {!! Form::label('guest_email', 'Email', array('class' => 'col-md-1 control-label')) !!}

                            <div class="col-md-4 col-rg-offset-1">
                                {!! Form::text('guest_email', $booking->guest_email, $attributes = array('class' =>
                                'form-control', 'id' => 'guest_email', 'placeholder' => '')) !!}
                                {!! $errors->first('guest_email', '
                                <div class="note note-error">:message</div>
                                ') !!}</div>

                            {!! Form::label('guest_country', 'Country', array('class' => 'col-md-1 control-label')) !!}

                            <div class="col-md-1">
                                {!! Form::text('guest_country', $booking->guest_country, $attributes = array('class'
                                => 'form-control', 'id' => 'guest_country', 'placeholder' => 'DE')) !!}
                                {!! $errors->first('guest_country', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>


                        <div class="form-group">
                            {!! Form::label('inquiry_date', 'Inquiry', array('class' => 'col-md-1 control-label'))
                            !!}
                            <div class="col-md-2">
                                {!! Form::date('inquiry_date', $booking->inquiry_date, $attributes = array('class'
                                => 'form-control', 'id' => 'inquiry_date', 'placeholder' => '2014-12-01')) !!}
                                {!! $errors->first('inquiry_date', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                            {!! Form::label('arrival_date', 'Arrival', array('class' => 'col-md-1 control-label')) !!}

                            <div class="col-md-2">
                                {!! Form::date('arrival_date', $booking->arrival_date, $attributes = array('class'
                                => 'form-control', 'id' => 'arrival_date', 'placeholder' => '2014-12-01')) !!}
                                {!! $errors->first('arrival_date', '
                                <div class="note note-error">:message</div>
                                ') !!}

                                {!! Form::label('arrival_time', 'Arrival time', array('class' => 'sr-only')) !!}
                                {!! Form::text('arrival_time', $booking->arrival_time, $attributes = array('class'
                                => 'form-control date', 'id' => 'arrival_time', 'placeholder' => '18:00')) !!}
                                {!! $errors->first('arrival_time', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>

                            {!! Form::label('departure_date', 'Departure', array('class' => 'col-md-1 control-label'))
                            !!}
                            <div class="col-md-2">
                                {!! Form::date('departure_date', $booking->departure_date, $attributes =
                                array('class' => 'form-control', 'id' => 'departure_date', 'placeholder' =>
                                '2014-12-01')) !!}
                                {!! $errors->first('departure_date', '
                                <div class="note note-error">:message</div>
                                ') !!}

                                {!! Form::label('departure_time', 'Departure time', array('class' => 'sr-only'))
                                !!}
                                {!! Form::text('departure_time', $booking->departure_time, $attributes =
                                array('class' => 'form-control', 'id' => 'departure_time', 'placeholder' => '18:00'))
                                !!}
                                {!! $errors->first('departure_time', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>

                        </div>


                        <div class="form-group">
                            {!! Form::label('comment', 'Comment', array('class' => 'col-md-1 control-label')) !!}

                            <div class="col-md-4">
                                {!! Form::textarea('comment', $booking->comment, $attributes = array('class' =>
                                'form-control', 'id' => 'comment', 'placeholder' => 'Comment', 'rows' => 3)) !!}
                                {!! $errors->first('comment', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>


                            {!! Form::label('airbnb_conversation_id', 'AirBnB Conversation ID', array('class' =>
                            'col-md-2 control-label')) !!}
                            <div class="col-md-4">
                                {!! Form::text('airbnb_conversation_id', $booking->airbnb_conversation_id, $attributes =
                                array('class' => 'form-control', 'id' => 'airbnb_conversation_id', 'placeholder' => '1id8x912'))
                                !!}
                                {!! $errors->first('airbnb_conversation_id', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('confirmation_code', 'Confirmation code', array('class' =>'col-md-2 control-label')) !!}
                            <div class="col-md-4">
                                {!! Form::text('confirmation_code', $booking->confirmation_code, $attributes =
                                array('class' => 'form-control', 'id' => 'confirmation_code', 'placeholder' => '1id8x912'))
                                !!}
                                {!! $errors->first('confirmation_code', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('booking_status_id', 'Status', array('class' => 'col-md-1 control-label')) !!}
                            <div class="col-md-2">
                                {!! Form::select('booking_status_id', $bookingStatuses, $booking->booking_status_id,array('class' =>
                                        'form-control')) !!}
                                {!! $errors->first('booking_status_id', '<div class="note note-error">:message</div>') !!} </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('resolution_id', 'Resolution', array('class' => 'col-md-1 control-label')) !!}
                            <div class="col-md-2">
                                {!! Form::select('resolution_id', $resolutions->prepend('', ''), optional($booking->resolution)->id, array('class' => 'form-control')) !!}
                                {!! $errors->first('resolution_id', '<div class="note note-error">:message</div>') !!} </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-1">
                                {!! Form::submit('Update booking', array('class' => 'btn btn-primary')) !!}
                            </div>
                            <div class="col-md-2 col-md-offset-1">
                                <a class="btn btn-default" href="{!! route('bookingDelete', $booking->id) !!}">Delete
                                    booking</a>
                            </div>

                            <div class="pull-right"><a class="btn btn-link" href="{!! route('bookings') !!}"><i
                                            class="fa fa-arrow-left"
                                            aria-hidden="true"></i>
                                    {{ trans('bookings/edit.link_text_back_to_overview') }}</a></div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop