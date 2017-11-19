@extends('layouts.app')

@section('title')
    TimeLogs :: New :: @parent
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {!! trans('time_logs/create.headline_create') !!}
                    </div>
                    <div class="panel-body">


                        {!! Form::open(array('route' => 'timeLogStore', 'method' => 'post', 'class' =>
                        'form-horizontal'))
                        !!}

                        <div class="form-group">
                            {!! Form::label('listing_id', 'Listing', array('class' => 'col-md-1 control-label')) !!}

                            <div class="col-md-3">
                                {!! Form::select('listing_id', $listings, \Request::old('listing_id'), array('class' =>
                                'form-control')) !!}
                                {!! $errors->first('listing_id', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>


                        <div class="form-group">
                            {!! Form::label('start_date', 'Start', array('class' => 'col-md-1 control-label'))
                            !!}
                            <div class="col-md-2">
                                {!! Form::date('start_date', \Request::old('start_date'), $attributes = array('class'
                                => 'form-control', 'id' => 'start_date', 'placeholder' => '2014-12-01')) !!}
                                {!! $errors->first('start_date', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>

                            {!! Form::label('start_time', 'Start time', array('class' => 'sr-only')) !!}

                            <div class="col-md-2">

                                {!! Form::text('start_time', \Request::old('arrival_time'), $attributes = array('class'
                                => 'form-control', 'id' => 'arrival_time', 'placeholder' => '18:00')) !!}
                                {!! $errors->first('arrival_time', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>

                            {!! Form::label('end_time', 'Finish time', array('class' => 'sr-only')) !!}

                            <div class="col-md-2">

                                {!! Form::text('end_time', \Request::old('end_time') ? \Request::old('end_time') : \Carbon\Carbon::now()->format(trans('global.time_format')), $attributes = array('class'
                                => 'form-control', 'id' => 'end_time', 'placeholder' => \Carbon\Carbon::now()->format(trans('global.time_format')))) !!}
                                {!! $errors->first('end_time', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>

                        </div>


                        <div class="form-group">

                            {!! Form::label('comment', 'Comment', array('class' => 'col-md-1 control-label')) !!}

                            <div class="col-md-4">
                                {!! Form::textarea('comment', \Request::old('comment'), $attributes = array('class' =>
                                'form-control', 'id' => 'comment', 'placeholder' => 'Comment', 'rows' => 3)) !!}
                                {!! $errors->first('comment', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>



                        </div>


                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-1">
                                {!! Form::submit('Save time', array('class' => 'btn btn-primary')) !!}
                            </div>

                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop