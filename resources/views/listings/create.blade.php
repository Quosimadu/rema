@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Add new listing</h1>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(array('route' => 'listingStore', 'method' => 'post', 'class' =>
                        'form-horizontal')) !!}

                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('name', 'Name', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-8">
                                {!! Form::text('name', \Request::old('name'), $attributes = array('class' =>
                                'form-control', 'id' => 'name', 'placeholder' => 'a good name')) !!}
                                {!! $errors->first('name', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('beds', 'Beds', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::number('beds', \Request::old('beds'), $attributes = array('class' =>
                                'form-control', 'id' => 'beds', 'placeholder' => 'x')) !!}
                                {!! $errors->first('beds', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                            <div class="col-md-2 col-md-offset-2">
                                {!! Form::label('guests', 'Guests', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::number('guests', \Request::old('guests'), $attributes = array('class' =>
                                'form-control', 'id' => 'guests', 'placeholder' => 'x')) !!}
                                {!! $errors->first('guests', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('address', 'Address', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-8">
                                {!! Form::textarea('address', \Request::old('address'), $attributes = array('class' =>
                                'form-control', 'id' => 'address', 'placeholder' => 'Street', 'rows' => 3)) !!}
                                {!! $errors->first('address', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('check_in_time', 'Check-in time', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::text('check_in_time', \Request::old('check_in_time'), $attributes = array('class'
                                => 'form-control date', 'id' => 'check_in_time', 'placeholder' => '10:00')) !!}
                                {!! $errors->first('check_in_time', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                            <div class="col-md-2  col-md-offset-2">
                                {!! Form::label('check_out_time', 'Check-out time', array('class' => 'control-label'))
                                !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::text('check_out_time', \Request::old('check_out_time'), $attributes = array('class'
                                => 'form-control date', 'id' => 'check_out_time', 'placeholder' => '16:00')) !!}
                                {!! $errors->first('check_out_time', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('airbnb_listing_id', 'AirBnB listing ID', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::text('airbnb_listing_id', \Request::old('airbnb_listing_id'), $attributes = array('class' =>
                                'form-control', 'id' => 'airbnb_listing_id', 'placeholder' => '172846')) !!}
                                {!! $errors->first('airbnb_listing_id', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                {!! Form::submit('Save new listing', array('class' => 'btn btn-primary')) !!}

                            </div>
                            <div class="pull-right"><a class="btn btn-link" href="{!! route('listings') !!}">Back to
                                    listings overview</a></div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop